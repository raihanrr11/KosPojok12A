@extends('admin.layout')

@section('content')
    <div
        class="sticky top-0 z-20 bg-gray-50/80 backdrop-blur-md -mx-4 px-4 sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8 py-6 border-b border-gray-100 mb-6">
        <div class="space-y-8">

            {{-- Header --}}
            <div
                class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 p-8 shadow-xl">
                <div class="relative z-10">
                    <h1 class="text-3xl font-bold text-white">Pengaturan Informasi Kos</h1>
                    <p class="mt-2 text-indigo-100">Kelola informasi dan detail kos yang ditampilkan kepada penghuni</p>
                </div>
                <div class="absolute top-0 right-0 -mt-4 -mr-4 h-32 w-32 rounded-full bg-white opacity-10"></div>
                <div class="absolute bottom-0 left-0 -mb-8 -ml-8 h-40 w-40 rounded-full bg-white opacity-5"></div>
            </div>

            {{-- ===== PENGUMUMAN KOS (Form Terpisah) ===== --}}
            <form method="POST" action="{{ route('admin.settings.update') }}">
                @csrf

                {{-- Penanda bahwa ini hanya form pengumuman --}}
                <input type="hidden" name="_form_type" value="announcement">

                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-amber-50 to-yellow-50">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-8 h-8 rounded-lg bg-gradient-to-br from-amber-400 to-yellow-500 flex items-center justify-center shadow-sm">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-base font-bold text-gray-800">Pengumuman Kos</h2>
                                    <p class="text-xs text-gray-500 mt-0.5">Akan ditampilkan di Dashboard seluruh penghuni
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <textarea name="dorm_announcement" rows="4"
                            class="block w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:ring-2 focus:ring-amber-400 focus:border-amber-400 focus:bg-white transition resize-none"
                            placeholder="Tulis pengumuman penting di sini untuk seluruh penghuni kos... Contoh: Akan ada perbaikan pompa air pada Senin 26 Mei pukul 08.00–12.00 WIB.">{{ old('dorm_announcement', $settings['dorm_announcement'] ?? '') }}</textarea>
                        <div class="flex items-center justify-between mt-4">
                            <p class="text-xs text-gray-400 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd" />
                                </svg>
                                Kosongkan jika tidak ada pengumuman aktif
                            </p>
                            <button type="submit"
                                class="inline-flex items-center px-5 py-2.5 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-amber-400 to-yellow-500 hover:from-amber-500 hover:to-yellow-600 shadow-md shadow-amber-200 transform hover:scale-105 transition-all duration-200">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Simpan Pengumuman
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            {{-- ===== INFORMASI KOS (Form Utama) ===== --}}
            <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
                @csrf

                <input type="hidden" name="_form_type" value="settings">

                {{-- General Info --}}
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-indigo-50 to-purple-50">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-sm">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <h2 class="text-base font-bold text-gray-800">Informasi Umum</h2>
                        </div>
                    </div>
                    <div class="p-6 grid grid-cols-1 gap-5 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">
                                Nama Kos <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="dorm_name" required
                                value="{{ old('dorm_name', $settings['dorm_name']) }}"
                                class="block w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition @error('dorm_name') border-red-400 @enderror"
                                placeholder="Contoh: Kos Putra">
                            @error('dorm_name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi Singkat</label>
                            <textarea name="dorm_description" rows="3"
                                class="block w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition"
                                placeholder="Deskripsi singkat tentang kos Anda...">{{ old('dorm_description', $settings['dorm_description']) }}</textarea>
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Lengkap</label>
                            <textarea name="dorm_address" rows="2"
                                class="block w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition"
                                placeholder="Jl. Contoh No. 1, RT 01/RW 02">{{ old('dorm_address', $settings['dorm_address']) }}</textarea>
                            @error('dorm_address')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Kota / Kabupaten</label>
                            <input type="text" name="dorm_city" value="{{ old('dorm_city', $settings['dorm_city']) }}"
                                class="block w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition"
                                placeholder="Malang">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Jam Operasional</label>
                            <input type="text" name="dorm_open_hours"
                                value="{{ old('dorm_open_hours', $settings['dorm_open_hours']) }}"
                                class="block w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition"
                                placeholder="07.00 – 22.00 WIB">
                        </div>
                    </div>
                </div>

                {{-- Contact Info --}}
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-cyan-50">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center shadow-sm">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <h2 class="text-base font-bold text-gray-800">Informasi Kontak</h2>
                        </div>
                    </div>
                    <div class="p-6 grid grid-cols-1 gap-5 sm:grid-cols-2">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Telepon</label>
                            <input type="text" name="dorm_phone" value="{{ old('dorm_phone', $settings['dorm_phone']) }}"
                                class="block w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition"
                                placeholder="0341-xxxxxx">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">WhatsApp</label>
                            <input type="text" name="dorm_whatsapp"
                                value="{{ old('dorm_whatsapp', $settings['dorm_whatsapp']) }}"
                                class="block w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition"
                                placeholder="08xxxxxxxxxx">
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                            <input type="email" name="dorm_email" value="{{ old('dorm_email', $settings['dorm_email']) }}"
                                class="block w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition @error('dorm_email') border-red-400 @enderror"
                                placeholder="kos@email.com">
                            @error('dorm_email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                {{-- Bank Account --}}
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-green-50 to-emerald-50">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-lg bg-gradient-to-br from-green-500 to-emerald-500 flex items-center justify-center shadow-sm">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                            </div>
                            <h2 class="text-base font-bold text-gray-800">Rekening Bank Pembayaran</h2>
                        </div>
                    </div>
                    <div class="p-6 grid grid-cols-1 gap-5 sm:grid-cols-2">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Bank</label>
                            <input type="text" name="dorm_bank_name"
                                value="{{ old('dorm_bank_name', $settings['dorm_bank_name']) }}"
                                class="block w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition"
                                placeholder="BCA / BRI / Mandiri / dll">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Rekening</label>
                            <input type="text" name="dorm_bank_account_no"
                                value="{{ old('dorm_bank_account_no', $settings['dorm_bank_account_no']) }}"
                                class="block w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm font-mono focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition"
                                placeholder="1234567890">
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Atas Nama</label>
                            <input type="text" name="dorm_bank_account_name"
                                value="{{ old('dorm_bank_account_name', $settings['dorm_bank_account_name']) }}"
                                class="block w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition"
                                placeholder="Nama Pemilik Rekening">
                        </div>
                    </div>
                </div>

                {{-- Save Button --}}
                <div class="flex justify-end">
                    <button type="submit"
                        class="inline-flex items-center px-8 py-3 border border-transparent rounded-xl shadow-md text-sm font-bold text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 transform hover:scale-105 transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection