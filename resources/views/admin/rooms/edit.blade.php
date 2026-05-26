@extends('admin.layout')

@section('content')
    <div class="space-y-6" x-data="{ deleteModal: false, deleteTarget: { roomId: '', index: '' } }">
        <br>
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-900 text-transparent bg-clip-text">
                Edit Kamar {{ $room->room_number }}</h2>
            <a href="{{ route('admin.rooms.index') }}"
                class="text-sm font-bold text-black-600 hover:text-indigo-900 transition-colors">
                &larr; Kembali ke Daftar
            </a>
        </div>

        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="p-8">
                <form action="{{ route('admin.rooms.update', $room) }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Room Number -->
                        <div class="space-y-2">
                            <label for="room_number" class="text-sm font-bold text-gray-700 ml-1">Nomor Kamar</label>
                            <input type="text" name="room_number" id="room_number"
                                value="{{ old('room_number', $room->room_number) }}" required
                                class="block w-full rounded-2xl border-gray-200 bg-gray-50 px-4 py-3 text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 transition-all duration-300">
                            @error('room_number') <p class="text-sm text-red-600 mt-1 ml-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Price -->
                        <div class="space-y-2">
                            <label for="price" class="text-sm font-bold text-gray-700 ml-1">Harga per Bulan</label>
                            <div class="relative group">
                                <span
                                    class="absolute left-4 top-3.5 text-gray-400 group-focus-within:text-indigo-600 transition-colors">Rp</span>
                                <input type="number" name="price" id="price" value="{{ old('price', $room->price) }}"
                                    required
                                    class="block w-full rounded-2xl border-gray-200 bg-gray-50 pl-12 pr-4 py-3 text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 transition-all duration-300">
                            </div>
                            @error('price') <p class="text-sm text-red-600 mt-1 ml-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Status -->
                        <div class="space-y-2">
                            <label for="status" class="text-sm font-bold text-gray-700 ml-1">Status Kamar</label>
                            <select name="status" id="status" required
                                class="block w-full rounded-2xl border-gray-200 bg-gray-50 px-4 py-3 text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 transition-all duration-300">
                                <option value="available" {{ old('status', $room->status) == 'available' ? 'selected' : '' }}>
                                    Tersedia</option>
                                <option value="occupied" {{ old('status', $room->status) == 'occupied' ? 'selected' : '' }}>
                                    Terisi</option>
                                <option value="maintenance" {{ old('status', $room->status) == 'maintenance' ? 'selected' : '' }}>Perbaikan</option>
                            </select>
                            @error('status') <p class="text-sm text-red-600 mt-1 ml-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Facilities -->
                        <div class="space-y-2">
                            <label for="facilities" class="text-sm font-bold text-gray-700 ml-1">Fasilitas (Pisahkan dengan
                                koma)</label>
                            <input type="text" name="facilities" id="facilities"
                                value="{{ old('facilities', $facilitiesStr ?? '') }}"
                                placeholder="Contoh: Kasur, Lemari, WiFi"
                                class="block w-full rounded-2xl border-gray-200 bg-gray-50 px-4 py-3 text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 transition-all duration-300">
                            @error('facilities') <p class="text-sm text-red-600 mt-1 ml-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="space-y-2">
                        <label for="description" class="text-sm font-bold text-gray-700 ml-1">Deskripsi & Fasilitas</label>
                        <textarea name="description" id="description" rows="4"
                            class="block w-full rounded-2xl border-gray-200 bg-gray-50 px-4 py-3 text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 transition-all duration-300 resize-none">{{ old('description', $room->description) }}</textarea>
                        @error('description') <p class="text-sm text-red-600 mt-1 ml-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Photos Management -->
                    <div class="space-y-4">
                        <label class="text-sm font-bold text-gray-700 ml-1">Foto Kamar Saat Ini</label>
                        @if($room->photos && count($room->photos) > 0)
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                                @foreach($room->photos as $index => $photo)
                                    <div class="group relative aspect-square rounded-2xl overflow-hidden shadow-md">
                                        <img src="{{ Storage::url($photo) }}" alt="Room photo" class="w-full h-full object-cover">
                                        <div
                                            class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center backdrop-blur-[2px]">
                                            <button type="button"
                                                @click="deleteTarget = { roomId: '{{ $room->id }}', index: '{{ $index }}' }; deleteModal = true"
                                                class="p-3 bg-red-500 text-white rounded-xl hover:bg-red-600 transform hover:scale-110 transition-all shadow-lg">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="p-8 border-2 border-dashed border-gray-200 rounded-3xl text-center bg-gray-50">
                                <p class="text-gray-500 font-medium">Belum ada foto kamar.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Add New Photos -->
                    <div class="space-y-2">
                        <label for="photos" class="text-sm font-bold text-gray-700 ml-1">Tambah Foto Baru</label>
                        <div class="relative">
                            <input type="file" name="photos[]" id="photos" multiple accept="image/*"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition-all">
                            <p class="text-xs text-gray-500 mt-2 ml-1 italic">Dapat memilih lebih dari satu foto. Format:
                                JPG, PNG, JPEG. Max: 2MB per file.</p>
                        </div>
                        @error('photos.*') <p class="text-sm text-red-600 mt-1 ml-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="pt-6">
                        <button type="submit"
                            class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 rounded-2xl text-sm font-black text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 shadow-lg shadow-indigo-500/25 transform hover:scale-[1.02] transition-all">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Hidden Form for Photo Deletion -->
        <form id="delete-photo-form" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>

        {{-- Delete Photo Confirmation Modal --}}
        <template x-teleport="body">
            <div x-show="deleteModal" x-cloak class="fixed inset-0 z-[9999] flex items-center justify-center p-4"
                x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" @click="deleteModal = false"></div>
                <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-sm overflow-hidden"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0">
                    <div class="bg-gradient-to-br from-red-500 to-pink-600 px-6 pt-8 pb-6 text-center">
                        <div
                            class="mx-auto w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mb-4 ring-4 ring-white/30">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-black text-white">Hapus Foto Ini?</h3>
                        <p class="text-red-100 text-sm mt-1">Tindakan ini tidak dapat dibatalkan</p>
                    </div>
                    <div class="p-6">
                        <p class="text-sm text-gray-600 text-center font-medium mb-6">
                            Foto yang dihapus tidak dapat dikembalikan. Pastikan Anda ingin menghapus foto ini.
                        </p>
                        <div class="flex gap-3">
                            <button @click="deleteModal = false"
                                class="flex-1 px-4 py-3 border border-gray-200 rounded-xl text-sm font-bold text-gray-600 bg-white hover:bg-gray-50 transition">Batal</button>
                            <button @click="
                                                                const form = document.getElementById('delete-photo-form');
                                                                form.action = `/admin/rooms/${deleteTarget.roomId}/photos/${deleteTarget.index}`;
                                                                form.submit();"
                                class="flex-1 px-4 py-3 rounded-xl text-sm font-black text-white bg-gradient-to-r from-red-500 to-pink-600 shadow-lg shadow-red-500/30 transition transform hover:scale-[1.02]">Ya,
                                Hapus</button>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
    </div>
@endsection