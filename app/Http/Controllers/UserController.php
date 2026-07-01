<?php

// app/Http/Controllers/UserController.php - Updated with Complete Validation

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Complaint;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }

    public function dashboard()
    {
        $user = auth()->user();
        // Stats pribadi user
        $stats = [
            'total_payments' => $user->payments()->count(),
            'verified_payments' => $user->payments()->where('status', 'verified')->count(),
            'pending_payments' => $user->payments()->where('status', 'pending')->count(),
            'total_complaints' => $user->complaints()->count(),
            'open_complaints' => $user->complaints()->where('status', 'open')->count(),
        ];
        // Data pribadi user
        $recent_payments = $user->payments()->latest()->take(3)->get();
        $recent_complaints = $user->complaints()->latest()->take(3)->get();
        // Data publik untuk semua user
        $public_complaints = Complaint::public()
            ->with(['user', 'respondedBy'])
            ->latest()
            ->take(5)
            ->get();
        // Stats keluhan publik
        $public_stats = [
            'total_public_complaints' => Complaint::public()->count(),
            'open_public_complaints' => Complaint::public()->where('status', 'open')->count(),
            'resolved_public_complaints' => Complaint::public()->where('status', 'resolved')->count(),
        ];
        return view('user.dashboard', compact(
            'stats',
            'recent_payments',
            'recent_complaints',
            'public_complaints',
            'public_stats'
        ));
    }

    public function profile()
    {
        $user = auth()->user();
        return view('user.profile', compact('user'));
    }

    public function dormInfo()
    {
        $keys = [
            'dorm_name',
            'dorm_address',
            'dorm_city',
            'dorm_email',
            'dorm_whatsapp',
            'dorm_bank_name',
            'dorm_bank_account_no',
            'dorm_bank_account_name',
            'dorm_description',
            'dorm_open_hours',
        ];
        $info = [];
        foreach ($keys as $key) {
            $info[$key] = Setting::get($key);
        }
        return view('user.dorm-info', compact('info'));
    }

    /**
     * Method untuk melihat semua keluhan publik
     */
    public function publicComplaints(Request $request)
    {
        $query = Complaint::public()->with(['user', 'respondedBy']);

        if ($request->filled('status')) {
            if ($request->status === 'pending') {
                $query->where('status', 'open');
            } elseif ($request->status === 'in_progress') {
                $query->where('status', 'in_progress');
            } elseif ($request->status === 'completed') {
                $query->whereIn('status', ['resolved', 'closed']);
            }
        }
        $complaints = $query->latest()->paginate(10)->withQueryString();
        $counts = [
            'pending' => Complaint::public()->where('status', 'open')->count(),
            'in_progress' => Complaint::public()->where('status', 'in_progress')->count(),
            'completed' => Complaint::public()->whereIn('status', ['resolved', 'closed'])->count(),
        ];
        return view('user.public-complaints', compact('complaints', 'counts'));
    }

    // ============================================
    // PAYMENT MANAGEMENT
    // ============================================

    public function payments(Request $request)
    {
        $query = auth()->user()->payments();

        if ($request->filled('month')) {
            $query->whereMonth('payment_date', $request->month);
        }

        if ($request->filled('year')) {
            $query->whereYear('payment_date', $request->year);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $payments = $query->latest()->paginate(10)->withQueryString();
        return view('user.payments.index', compact('payments'));
    }

    public function paymentCreate()
    {
        $bank_info = [
            'name' => Setting::get('dorm_bank_name'),
            'no' => Setting::get('dorm_bank_account_no'),
            'holder' => Setting::get('dorm_bank_account_name'),
        ];
        return view('user.payments.create', compact('bank_info'));
    }

    public function paymentStore(Request $request)
    {
        $validated = $request->validate([
            // Amount - Hanya angka, minimal 1000
            'amount' => [
                'required',
                'numeric',
                'min:1000',
                'max:100000000',
            ],
            // Payment Date - Tidak boleh masa depan
            'payment_date' => [
                'required',
                'date',
                'before_or_equal:today',
                'after:2020-01-01',
            ],
            // Payment Method - Hanya pilihan yang valid
            'payment_method' => [
                'required',
                'string',
                'in:cash,bank_transfer,e_wallet,other',
            ],
            // Description - Huruf, angka, dan tanda baca
            'description' => [
                'nullable',
                'string',
                'max:500',
                'regex:/^[a-zA-Z0-9\s,.\-\/()]+$/',
            ],
            // Proof File - Gambar atau PDF
            'proof_file' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:2048', // 2MB
            ],
        ], [
            // Custom Error Messages
            'amount.required' => 'Jumlah pembayaran tidak boleh kosong!',
            'amount.numeric' => 'Jumlah pembayaran harus berupa angka!',
            'amount.min' => 'Jumlah pembayaran minimal Rp 1.000!',
            'amount.max' => 'Jumlah pembayaran maksimal Rp 100.000.000!',

            'payment_date.required' => 'Tanggal pembayaran tidak boleh kosong!',
            'payment_date.date' => 'Format tanggal tidak valid!',
            'payment_date.before_or_equal' => 'Tanggal pembayaran tidak boleh di masa depan!',
            'payment_date.after' => 'Tanggal pembayaran tidak valid!',

            'payment_method.required' => 'Metode pembayaran tidak boleh kosong!',
            'payment_method.in' => 'Metode pembayaran tidak valid!',

            'description.regex' => 'Deskripsi mengandung karakter yang tidak diperbolehkan!',
            'description.max' => 'Deskripsi maksimal 500 karakter!',

            'proof_file.required' => 'Bukti pembayaran tidak boleh kosong!',
            'proof_file.file' => 'File bukti pembayaran tidak valid!',
            'proof_file.mimes' => 'Format file hanya JPG, JPEG, PNG, atau PDF!',
            'proof_file.max' => 'Ukuran file maksimal 2MB!',
        ]);

        // Upload proof file
        $proofPath = null;
        if ($request->hasFile('proof_file')) {
            $file = $request->file('proof_file');
            $filename = time() . '_' . auth()->id() . '_' . $file->getClientOriginalName();
            // Sanitasi filename
            $filename = preg_replace('/[^a-zA-Z0-9._-]/', '_', $filename);
            $proofPath = $file->storeAs('payment-proofs', $filename, 'public');
        }

        // Sanitasi description
        if (isset($validated['description'])) {
            $validated['description'] = trim($validated['description']);
        }

        Payment::create([
            'user_id' => auth()->id(),
            'amount' => $validated['amount'],
            'payment_date' => $validated['payment_date'],
            'payment_method' => $validated['payment_method'],
            'description' => $validated['description'] ?? null,
            'proof_file' => $proofPath,
            'status' => 'pending',
        ]);
        return redirect()->route('user.payments')->with('success', 'Bukti pembayaran berhasil diupload dan menunggu verifikasi admin');
    }

    public function paymentShow(Payment $payment)
    {
        // Authorization check
        if ($payment->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        return view('user.payments.show', compact('payment'));
    }

    // ============================================
    // COMPLAINT MANAGEMENT
    // ============================================

    public function complaints(Request $request)
    {
        $query = auth()->user()->complaints();

        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }

        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        if ($request->filled('visibility')) {
            $isPublic = $request->visibility === 'public';
            $query->where('is_public', $isPublic);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $complaints = $query->latest()->paginate(10)->withQueryString();
        return view('user.complaints.index', compact('complaints'));
    }

    public function complaintCreate()
    {
        return view('user.complaints.create');
    }

    public function complaintStore(Request $request)
    {
        $validated = $request->validate([
            'subject' => [
                'required',
                'string',
                'min:5',
                'max:255',
            ],
            'description' => [
                'required',
                'string',
                'min:10',
                'max:2000',
            ],
            'category' => [
                'required',
                'in:maintenance,facility,neighbor,cleanliness,security,other',
            ],

            'priority' => [
                'required',
                'in:low,medium,high',
            ],
            // Public/Private flags
            'is_public' => 'boolean',
            // Optional 
            'photo' => [
                'nullable',
                'image',
                'mimes:jpeg,jpg,png',
                'max:3072',
            ],
        ], [
            // Custom Error Messages
            'subject.required' => 'Judul keluhan tidak boleh kosong!',
            'subject.min' => 'Judul keluhan minimal 5 karakter!',
            'subject.max' => 'Judul keluhan maksimal 255 karakter!',

            'description.required' => 'Deskripsi keluhan tidak boleh kosong!',
            'description.min' => 'Deskripsi keluhan minimal 10 karakter!',
            'description.max' => 'Deskripsi keluhan maksimal 2000 karakter!',

            'category.required' => 'Kategori keluhan tidak boleh kosong!',
            'category.in' => 'Kategori keluhan tidak valid!',

            'priority.required' => 'Prioritas keluhan tidak boleh kosong!',
            'priority.in' => 'Prioritas keluhan tidak valid!',

            'photo.image' => 'File harus berupa gambar!',
            'photo.mimes' => 'Format foto hanya JPG, JPEG, atau PNG!',
            'photo.max' => 'Ukuran foto maksimal 3MB!',
        ]);
        // Sanitasi data
        $validated['subject'] = trim($validated['subject']);
        $validated['description'] = trim($validated['description']);
        // Handle photo upload
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_complaint_' . auth()->id() . '.' . $file->getClientOriginalExtension();
            $photoPath = $file->storeAs('complaint-photos', $filename, 'public');
        }
        Complaint::create([
            'user_id' => auth()->id(),
            'subject' => $validated['subject'],
            'description' => $validated['description'],
            'photo' => $photoPath,
            'category' => $validated['category'],
            'priority' => $validated['priority'],
            'status' => 'open',
            'is_public' => $request->boolean('is_public'),
        ]);
        $message = $validated['is_public'] ?? false
            ? 'Keluhan publik berhasil diajukan dan dapat dilihat oleh semua penghuni'
            : 'Keluhan pribadi berhasil diajukan dan akan segera ditanggapi oleh admin';
        return redirect()->route('user.complaints')->with('success', $message);
    }

    public function complaintShow(Complaint $complaint)
    {
        // Bisa lihat jika: pemilik keluhan, atau keluhan publik
        if ($complaint->user_id !== auth()->id() && !$complaint->is_public) {
            abort(403, 'Unauthorized access');
        }

        return view('user.complaints.show', compact('complaint'));
    }

    /**
     * Method untuk detail keluhan publik
     */
    public function publicComplaintShow(Complaint $complaint)
    {
        // Pastikan keluhan benar-benar publik
        if (!$complaint->is_public) {
            abort(404, 'Keluhan tidak ditemukan');
        }

        return view('user.public-complaint-show', compact('complaint'));
    }
}