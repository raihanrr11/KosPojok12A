<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::latest()->paginate(12);
        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('admin.rooms.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_number' => 'required|string|max:255|unique:rooms',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:available,occupied,maintenance',
            'facilities' => 'nullable|string',
            'description' => 'nullable|string',
            'photos.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $photos = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('rooms', $filename, 'public');
                $photos[] = $path;
            }
        }

        $facilities = [];
        if (!empty($validated['facilities'])) {
            $facilities = array_map('trim', explode(',', $validated['facilities']));
        }

        Room::create([
            'room_number' => $validated['room_number'],
            'price' => $validated['price'],
            'status' => $validated['status'],
            'facilities' => $facilities,
            'description' => $validated['description'],
            'photos' => $photos,
        ]);

        return redirect()->route('admin.rooms.index')->with('success', 'Kamar berhasil ditambahkan.');
    }

    public function show(Room $room)
    {
        return view('admin.rooms.show', compact('room'));
    }

    public function edit(Room $room)
    {
        $facilitiesStr = $room->facilities ? implode(', ', $room->facilities) : '';
        return view('admin.rooms.edit', compact('room', 'facilitiesStr'));
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'room_number' => 'required|string|max:255|unique:rooms,room_number,' . $room->id,
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:available,occupied,maintenance',
            'facilities' => 'nullable|string',
            'description' => 'nullable|string',
            'photos.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $photos = $room->photos ?? [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('rooms', $filename, 'public');
                $photos[] = $path;
            }
        }

        $facilities = [];
        if (!empty($validated['facilities'])) {
            $facilities = array_map('trim', explode(',', $validated['facilities']));
        }

        $oldRoomNumber = $room->room_number;

        $room->update([
            'room_number' => $validated['room_number'],
            'price' => $validated['price'],
            'status' => $validated['status'],
            'facilities' => $facilities,
            'description' => $validated['description'],
            'photos' => $photos,
        ]);

        // Jika nomor kamar berubah, ubah nomor kamar penghuni yang ada di kamar lama
        if ($oldRoomNumber !== $validated['room_number']) {
            \App\Models\User::where('room_number', $oldRoomNumber)
                ->update(['room_number' => $validated['room_number']]);
        }

        // Sinkronisasi harga sewa (monthly_rent) penghuni yang menempati kamar ini
        \App\Models\User::where('room_number', $validated['room_number'])
            ->update(['monthly_rent' => $validated['price']]);

        return redirect()->route('admin.rooms.index')->with('success', 'Kamar berhasil diperbarui.');
    }

    public function destroy(Room $room)
    {
        if ($room->photos) {
            foreach ($room->photos as $photo) {
                Storage::disk('public')->delete($photo);
            }
        }
        $room->delete();
        return redirect()->route('admin.rooms.index')->with('success', 'Kamar berhasil dihapus.');
    }

    public function deletePhoto(Room $room, $index)
    {
        $photos = $room->photos ?? [];
        
        if (isset($photos[$index])) {
            Storage::disk('public')->delete($photos[$index]);
            unset($photos[$index]);
            
            // Re-index array
            $room->update(['photos' => array_values($photos)]);
            
            return back()->with('success', 'Foto berhasil dihapus.');
        }

        return back()->with('error', 'Foto tidak ditemukan.');
    }
}
