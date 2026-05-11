@extends('user.layout')

@section('content')
<div class="max-w-2xl mx-auto space-y-6 pb-12">

    {{-- Header --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-red-600 via-pink-600 to-purple-600 p-8 shadow-xl">
        <div class="relative z-10">
            <h1 class="text-2xl font-bold text-white">Ajukan Keluhan</h1>
            <p class="mt-1 text-red-100 text-sm">Sampaikan masalah Anda agar segera ditindaklanjuti</p>
        </div>
        <div class="absolute top-0 right-0 -mt-4 -mr-4 h-28 w-28 rounded-full bg-white opacity-10"></div>
        <div class="absolute bottom-0 left-0 -mb-6 -ml-6 h-36 w-36 rounded-full bg-white opacity-5"></div>
    </div>

    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
            <h2 class="text-base font-bold text-gray-800">Formulir Keluhan</h2>
        </div>

        <form method="POST" action="{{ route('user.complaints.store') }}" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf

            {{-- Subject --}}
            <div>
                <label for="subject" class="block text-sm font-semibold text-gray-700 mb-1">
                    Judul Keluhan <span class="text-red-500">*</span>
                </label>
                <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required maxlength="255"
                    class="block w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition @error('subject') border-red-400 bg-red-50 @enderror"
                    placeholder="Contoh: Atap kamar bocor">
                @error('subject')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Category & Priority --}}
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <label for="category" class="block text-sm font-semibold text-gray-700 mb-1">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select name="category" id="category" required
                        class="block w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition @error('category') border-red-400 @enderror">
                        <option value="">Pilih Kategori</option>
                        <option value="maintenance" {{ old('category') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                        <option value="facility" {{ old('category') == 'facility' ? 'selected' : '' }}>Fasilitas</option>
                        <option value="neighbor" {{ old('category') == 'neighbor' ? 'selected' : '' }}>Tetangga</option>
                        <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('category')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="priority" class="block text-sm font-semibold text-gray-700 mb-1">
                        Prioritas <span class="text-red-500">*</span>
                    </label>
                    <select name="priority" id="priority" required
                        class="block w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition @error('priority') border-red-400 @enderror">
                        <option value="">Pilih Prioritas</option>
                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Rendah</option>
                        <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Sedang</option>
                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>Tinggi</option>
                    </select>
                    @error('priority')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Description --}}
            <div>
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">
                    Deskripsi Keluhan <span class="text-red-500">*</span>
                </label>
                <textarea name="description" id="description" rows="5" required
                    class="block w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition @error('description') border-red-400 bg-red-50 @enderror"
                    placeholder="Jelaskan keluhan Anda secara detail...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Photo Upload (optional) --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Foto Pendukung <span class="text-gray-400 font-normal">(opsional)</span>
                </label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-200 border-dashed rounded-xl bg-gray-50 hover:border-indigo-400 hover:bg-indigo-50 transition cursor-pointer"
                     onclick="document.getElementById('photo').click()">
                    <div class="space-y-1 text-center" id="photo-placeholder">
                        <svg class="mx-auto h-10 w-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="text-sm text-gray-500">Klik untuk upload foto</p>
                        <p class="text-xs text-gray-400">PNG, JPG hingga 3MB</p>
                    </div>
                    <img id="photo-preview" src="#" alt="Preview" class="hidden max-h-48 rounded-lg object-contain mx-auto">
                </div>
                <input type="file" name="photo" id="photo" accept="image/jpeg,image/jpg,image/png" class="hidden">
                @error('photo')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Visibility Settings --}}
            <div class="rounded-xl border border-gray-200 overflow-hidden" x-data="{ isPublic: {{ old('is_public') ? 'true' : 'false' }} }">
                <div class="px-5 py-3 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                    <h4 class="text-sm font-bold text-gray-800">Pengaturan Visibilitas</h4>
                    <p class="text-xs text-gray-500 mt-0.5">Pilih siapa yang dapat melihat keluhan Anda</p>
                </div>

                <div class="p-5 space-y-3">
                    {{-- Private Option --}}
                    <label class="flex items-start gap-4 p-4 rounded-xl border-2 cursor-pointer transition"
                           :class="!isPublic ? 'border-indigo-500 bg-indigo-50' : 'border-gray-200 bg-white hover:border-gray-300'">
                        <input type="radio" name="is_public" value="0" @change="isPublic = false"
                               {{ !old('is_public') ? 'checked' : '' }}
                               class="mt-0.5 h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                        <div>
                            <span class="flex items-center gap-1.5 text-sm font-semibold text-gray-900">
                                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                Pribadi (Private)
                            </span>
                            <p class="text-xs text-gray-500 mt-0.5">Hanya Anda dan admin yang dapat melihat keluhan ini</p>
                        </div>
                    </label>

                    {{-- Public Option --}}
                    <label class="flex items-start gap-4 p-4 rounded-xl border-2 cursor-pointer transition"
                           :class="isPublic ? 'border-green-500 bg-green-50' : 'border-gray-200 bg-white hover:border-gray-300'">
                        <input type="radio" name="is_public" value="1" @change="isPublic = true"
                               {{ old('is_public') ? 'checked' : '' }}
                               class="mt-0.5 h-4 w-4 text-green-600 border-gray-300 focus:ring-green-500">
                        <div>
                            <span class="flex items-center gap-1.5 text-sm font-semibold text-gray-900">
                                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/>
                                </svg>
                                Publik (Public)
                            </span>
                            <p class="text-xs text-gray-500 mt-0.5">Semua penghuni kos dapat melihat keluhan ini</p>
                        </div>
                    </label>

                </div>
            </div>

            {{-- Actions --}}
            <div class="flex justify-end gap-3 pt-2">
                <a href="{{ route('user.complaints') }}"
                    class="px-5 py-2.5 border border-gray-300 rounded-xl text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit"
                    class="inline-flex items-center px-6 py-2.5 border border-transparent rounded-xl shadow text-sm font-bold text-white bg-gradient-to-r from-red-600 to-pink-600 hover:from-red-700 hover:to-pink-700 transform hover:scale-105 transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    Ajukan Keluhan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Photo preview
    document.getElementById('photo').addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('photo-placeholder').classList.add('hidden');
            const preview = document.getElementById('photo-preview');
            preview.src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    });
</script>
@endsection