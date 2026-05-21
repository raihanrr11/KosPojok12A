<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Payment;
use App\Models\Complaint;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'pending_payments' => 0,
            'open_complaints' => 0,
            'monthly_revenue' => 0,
        ];

        $recent_payments = collect();
        $recent_complaints = collect();

        if (Schema::hasTable('payments') && Schema::hasColumn('payments', 'status')) {
            $stats['pending_payments'] = Payment::where('status', 'pending')->count();
            $stats['monthly_revenue'] = Payment::where('status', 'verified')
                ->whereMonth('created_at', now()->month)
                ->sum('amount');

            $recent_payments = Payment::with('user')
                ->where('status', 'pending')
                ->latest()
                ->take(5)
                ->get();
        }

        if (Schema::hasTable('complaints') && Schema::hasColumn('complaints', 'status')) {
            $stats['open_complaints'] = Complaint::where('status', 'open')->count();

            $recent_complaints = Complaint::with('user')
                ->where('status', 'open')
                ->latest()
                ->take(5)
                ->get();
        }

        // Chart Data
        $chartData = [
            'revenue_labels' => [],
            'revenue_data' => [],
            'payment_status_labels' => ['Pending', 'Verified', 'Rejected'],
            'payment_status_data' => [0, 0, 0],
        ];

        if (Schema::hasTable('payments') && Schema::hasColumn('payments', 'status')) {
            // Revenue for the last 6 months
            $revenues = Payment::where('status', 'verified')
                ->where('created_at', '>=', now()->subMonths(5)->startOfMonth())
                ->selectRaw('SUM(amount) as total, DATE_FORMAT(created_at, "%Y-%m") as month')
                ->groupBy('month')
                ->orderBy('month')
                ->get()
                ->pluck('total', 'month');

            for ($i = 5; $i >= 0; $i--) {
                $date = now()->subMonths($i);
                $monthKey = $date->format('Y-m');
                $chartData['revenue_labels'][] = $date->translatedFormat('F');
                $chartData['revenue_data'][] = $revenues->get($monthKey, 0);
            }

            // Payment status breakdown
            $chartData['payment_status_data'][0] = Payment::where('status', 'pending')->count();
            $chartData['payment_status_data'][1] = Payment::where('status', 'verified')->count();
            $chartData['payment_status_data'][2] = Payment::where('status', 'rejected')->count();
        }

        return view('admin.dashboard', compact('stats', 'recent_payments', 'recent_complaints', 'chartData'));
    }

    // User Management
    public function users(Request $request)
    {
        $query = User::where('role', 'user');

        if ($request->status === 'deleted') {
            $query->onlyTrashed();
        }

        $users = $query->orderByRaw('CAST(room_number AS UNSIGNED) ASC')->paginate(10)->withQueryString();
        return view('admin.users.index', compact('users'));
    }

    public function userShow(User $user)
    {
        if ($user->role !== 'user') {
            abort(404);
        }

        $payments = [];
        $complaints = [];

        if (Schema::hasTable('payments')) {
            $payments = Payment::where('user_id', $user->id)->latest()->take(5)->get();
        }

        if (Schema::hasTable('complaints')) {
            $complaints = Complaint::where('user_id', $user->id)->latest()->take(5)->get();
        }

        return view('admin.users.show', compact('user', 'payments', 'complaints'));
    }

    public function userCreate()
    {
        $availableRooms = \App\Models\Room::where('status', 'available')->get();
        return view('admin.users.create', compact('availableRooms'));
    }

    public function userStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', \Illuminate\Validation\Rule::unique('users')->whereNull('deleted_at')],
            'password' => 'required|string|min:8',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'room_number' => ['required', 'string', 'max:10', \Illuminate\Validation\Rule::unique('users')->whereNull('deleted_at')],
            'monthly_rent' => 'required|numeric|min:0',
            'date_of_birth' => 'nullable|date',
            'emergency_contact' => 'nullable|string',
        ]);

        // handle photo
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('user-photos', 'public');
        }

        // Ambil harga sewa dari harga kamar pusat
        $room = \App\Models\Room::where('room_number', $validated['room_number'])->first();
        $monthlyRent = $room ? $room->price : $validated['monthly_rent'];

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'photo' => $photoPath,
            'role' => 'user',
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'room_number' => $validated['room_number'],
            'monthly_rent' => $monthlyRent,
            'date_of_birth' => $validated['date_of_birth'] ?? null,
            'emergency_contact' => $validated['emergency_contact'] ?? null,
            'email_verified_at' => now(),
        ]);

        // Update the selected room status to occupied
        $room = \App\Models\Room::where('room_number', $user->room_number)->first();
        if ($room) {
            $room->update(['status' => 'occupied']);
        }

        return redirect()->route('admin.users')->with('success', 'Penghuni berhasil ditambahkan');
    }

    public function userEdit(User $user)
    {
        if ($user->role !== 'user') {
            abort(404);
        }
        $availableRooms = \App\Models\Room::where('status', 'available')
            ->orWhere('room_number', $user->room_number)
            ->get();
        return view('admin.users.edit', compact('user', 'availableRooms'));
    }

    public function userUpdatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $user = Auth::user();

        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        $path = $request->file('photo')->store('profile-photos', 'public');

        $user->photo = $path;
        $user->save();

        return redirect()->back()->with('success', 'Foto profil berhasil diupdate');
    }

    public function userUpdate(Request $request, User $user)
    {
        if ($user->role !== 'user') {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', \Illuminate\Validation\Rule::unique('users')->ignore($user->id)->whereNull('deleted_at')],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'room_number' => ['required', 'string', 'max:10', \Illuminate\Validation\Rule::unique('users')->ignore($user->id)->whereNull('deleted_at')],
            'monthly_rent' => 'required|numeric|min:0',
            'date_of_birth' => 'nullable|date',
            'emergency_contact' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }

            $validated['photo'] = $request->file('photo')->store('user-photos', 'public');
        }

        // Ambil harga sewa dari harga kamar pusat
        $room = \App\Models\Room::where('room_number', $validated['room_number'])->first();
        if ($room) {
            $validated['monthly_rent'] = $room->price;
        }

        $oldRoomNumber = $user->room_number;

        $user->update($validated);

        // If the room number changed, update room statuses
        if ($oldRoomNumber !== $user->room_number) {
            // Free the old room
            $oldRoom = \App\Models\Room::where('room_number', $oldRoomNumber)->first();
            if ($oldRoom) {
                $oldRoom->update(['status' => 'available']);
            }

            // Occupy the new room
            $newRoom = \App\Models\Room::where('room_number', $user->room_number)->first();
            if ($newRoom) {
                $newRoom->update(['status' => 'occupied']);
            }
        }

        return redirect()->route('admin.users')->with('success', 'Data penghuni berhasil diperbarui');
    }

    public function userDestroy(User $user)
    {
        if ($user->role !== 'user') {
            abort(404);
        }

        $user->delete();

        return redirect()->route('admin.users')->with('success', 'Data penghuni berhasil dihapus');
    }

    public function userDeletePhoto(User $user)
    {
        if ($user->role !== 'user') {
            abort(404);
        }

        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
            $user->update(['photo' => null]);
        }

        return back()->with('success', 'Foto penghuni berhasil dihapus');
    }

    // Payment Management
    public function payments(Request $request)
    {
        if (!Schema::hasTable('payments')) {
            return view('admin.payments.index', ['payments' => collect([])]);
        }

        if ($request->status === 'unpaid') {
            $paidUserIds = Payment::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->whereIn('status', ['pending', 'verified'])
                ->pluck('user_id');

            $unpaidUsers = User::where('role', 'user')
                ->whereNotIn('id', $paidUserIds);

            if ($request->filled('search')) {
                $unpaidUsers->where('name', 'like', '%' . $request->search . '%');
            }

            $paginator = $unpaidUsers->paginate(10);

            $paginator->getCollection()->transform(function ($user) {
                $payment = new Payment([
                    'amount' => $user->monthly_rent,
                    'status' => 'unpaid',
                    'payment_date' => now(),
                    'payment_method' => '-',
                ]);
                $payment->id = 'unpaid-' . $user->id;
                $payment->setRelation('user', $user);
                return $payment;
            });
            $paginator->appends($request->query());
            $payments = $paginator;

            return view('admin.payments.index', compact('payments'));
        }

        $query = Payment::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }
        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }
        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        $payments = $query->latest()->paginate(10);
        $payments->appends($request->query());

        return view('admin.payments.index', compact('payments'));
    }

    public function paymentsAll(Request $request)
    {
        if (!Schema::hasTable('payments')) {
            return view('admin.payments.all', ['payments' => collect([])]);
        }

        $query = Payment::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }
        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }
        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        $payments = $query->latest()->get();
        return view('admin.payments.all', compact('payments'));
    }

    public function paymentShow(Payment $payment)
    {
        $payment->load(['user', 'verifiedBy']);
        return view('admin.payments.show', compact('payment'));
    }

    public function paymentVerify(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'status' => 'required|in:verified,rejected',
            'admin_notes' => 'nullable|string',
        ]);

        $updateData = [
            'status' => $validated['status'],
            'verified_at' => now(),
            'verified_by' => auth()->id(),
        ];

        if (!empty($validated['admin_notes'])) {
            $updateData['admin_notes'] = $validated['admin_notes'];
        }

        $payment->update($updateData);

        $message = $validated['status'] === 'verified'
            ? 'Pembayaran berhasil diverifikasi'
            : 'Pembayaran ditolak';

        return redirect()->route('admin.payments')->with('success', $message);
    }

    // Complaint Management
    public function complaints(Request $request)
    {
        if (!Schema::hasTable('complaints')) {
            return view('admin.complaints.index', ['complaints' => collect([])]);
        }

        $query = Complaint::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('visibility')) {
            $query->where('is_public', $request->visibility);
        }
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }
        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }
        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        $complaints = $query->latest()->paginate(10);
        $complaints->appends($request->query());

        return view('admin.complaints.index', compact('complaints'));
    }

    public function complaintsAll(Request $request)
    {
        if (!Schema::hasTable('complaints')) {
            return view('admin.complaints.all', ['complaints' => collect([])]);
        }

        $query = Complaint::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('visibility')) {
            $query->where('is_public', $request->visibility);
        }
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }
        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }
        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        $complaints = $query->latest()->get();
        return view('admin.complaints.all', compact('complaints'));
    }

    public function complaintShow(Complaint $complaint)
    {
        $complaint->load(['user', 'respondedBy']);
        return view('admin.complaints.show', compact('complaint'));
    }

    public function complaintUpdate(Request $request, Complaint $complaint)
    {
        $validated = $request->validate([
            'status' => 'required|in:open,in_progress,resolved,closed',
            'admin_response' => 'nullable|string',
        ]);

        $updateData = [
            'status' => $validated['status'],
            'responded_at' => now(),
            'responded_by' => auth()->id(),
        ];

        if (!empty($validated['admin_response'])) {
            $updateData['admin_response'] = $validated['admin_response'];
        }

        $complaint->update($updateData);

        return redirect()->route('admin.complaints')->with('success', 'Keluhan berhasil diperbarui');
    }

    public function complaintDestroy(Complaint $complaint)
    {
        if ($complaint->status !== 'resolved') {
            return redirect()->back()->with('error', 'Hanya keluhan yang sudah selesai yang dapat dihapus.');
        }

        if ($complaint->photo) {
            Storage::delete($complaint->photo);
        }

        $complaint->delete();

        return redirect()->route('admin.complaints')->with('success', 'Keluhan berhasil dihapus.');
    }

    // Dorm Settings
    public function dormSettings()
    {
        $keys = [
            'dorm_name',
            'dorm_address',
            'dorm_city',
            'dorm_phone',
            'dorm_email',
            'dorm_whatsapp',
            'dorm_bank_name',
            'dorm_bank_account_no',
            'dorm_bank_account_name',
            'dorm_description',
            'dorm_open_hours',
            'dorm_announcement',
        ];
        $settings = [];
        foreach ($keys as $key) {
            $settings[$key] = Setting::get($key);
        }
        return view('admin.settings', compact('settings'));
    }

    public function dormSettingsUpdate(Request $request)
    {
        $formType = $request->input('_form_type', 'settings');

        // ===== FORM PENGUMUMAN SAJA =====
        if ($formType === 'announcement') {
            $validated = $request->validate([
                'dorm_announcement' => 'nullable|string|max:2000',
            ]);

            Setting::set('dorm_announcement', $validated['dorm_announcement'] ?? '');

            return redirect()->route('admin.settings')->with('success', 'Pengumuman berhasil disimpan!');
        }

        // ===== FORM INFORMASI KOS =====
        $validated = $request->validate([
            'dorm_name' => 'required|string|max:255',
            'dorm_address' => 'nullable|string|max:500',
            'dorm_city' => 'nullable|string|max:100',
            'dorm_phone' => 'nullable|string|max:20',
            'dorm_email' => 'nullable|email|max:255',
            'dorm_whatsapp' => 'nullable|string|max:20',
            'dorm_bank_name' => 'nullable|string|max:100',
            'dorm_bank_account_no' => 'nullable|string|max:50',
            'dorm_bank_account_name' => 'nullable|string|max:100',
            'dorm_description' => 'nullable|string|max:1000',
            'dorm_open_hours' => 'nullable|string|max:255',
        ]);

        foreach ($validated as $key => $value) {
            Setting::set($key, $value);
        }

        return redirect()->route('admin.settings')->with('success', 'Pengaturan kos berhasil disimpan!');
    }
}
