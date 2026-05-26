@extends('user.layout')

@section('content')
    <div style="background: var(--color-background-tertiary, #FFF9EB); min-height: 100vh; padding-bottom: 48px;">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
            {{-- Header --}}
            <div
                class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 p-8 shadow-xl">
                <div class="relative z-10">
                    <a href="{{ route('user.payments') }}"
                        class="inline-flex items-center text-green-100 hover:text-white text-sm font-semibold mb-4 transition-colors">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Riwayat
                    </a>
                    <h1 class="text-2xl font-bold text-white">Upload Bukti Pembayaran</h1>
                    <p class="mt-1 text-green-100 text-sm">Lampirkan bukti transfer untuk diverifikasi oleh admin</p>
                </div>
                <div class="absolute top-0 right-0 -mt-4 -mr-4 h-28 w-28 rounded-full bg-white opacity-10"></div>
                <div class="absolute bottom-0 left-0 -mb-6 -ml-6 h-36 w-36 rounded-full bg-white opacity-5"></div>
            </div>

            {{-- Form Card --}}
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                    <h2 class="text-base font-bold text-gray-800">Formulir Pembayaran</h2>
                </div>

                <form method="POST" action="{{ route('user.payments.store') }}" enctype="multipart/form-data"
                    class="p-6 space-y-6">
                    @csrf

                    {{-- Amount & Date --}}
                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                        {{-- Amount --}}
                        <div>
                            <label for="amount" class="block text-sm font-semibold text-gray-700 mb-1">
                                Jumlah Pembayaran <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="text-gray-400 text-sm font-semibold">Rp</span>
                                </div>
                                <input type="number" name="amount" id="amount"
                                    value="{{ old('amount', Auth::user()->monthly_rent) }}" required min="0" step="1"
                                    class="block w-full pl-10 rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-900 focus:ring-2 focus:ring-green-500 focus:border-green-500 focus:bg-white transition @error('amount') border-red-400 bg-red-50 @enderror"
                                    placeholder="0">
                            </div>
                            @error('amount')
                                <x-input-error :messages="[$message]" />
                            @enderror
                        </div>

                        {{-- Payment Date --}}
                        <div>
                            <label for="payment_date" class="block text-sm font-semibold text-gray-700 mb-1">
                                Tanggal Pembayaran <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="payment_date" id="payment_date"
                                value="{{ old('payment_date', date('Y-m-d')) }}" required
                                class="block w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-900 focus:ring-2 focus:ring-green-500 focus:border-green-500 focus:bg-white transition @error('payment_date') border-red-400 bg-red-50 @enderror">
                            @error('payment_date')
                                <x-input-error :messages="[$message]" />
                            @enderror
                        </div>
                    </div>

                    {{-- Payment Method --}}
                    <div>
                        <label for="payment_method" class="block text-sm font-semibold text-gray-700 mb-2">
                            Metode Pembayaran <span class="text-red-500">*</span>
                        </label>

                        {{-- Note referring to Info Kos --}}
                        <div class="mb-4 bg-gray-50 border border-gray-200 rounded-xl p-4 flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="text-xs text-gray-600 leading-relaxed">
                                <span class="font-bold text-gray-800">Catatan:</span> Nomor rekening tujuan transfer dapat
                                Anda
                                lihat di menu
                                <a href="{{ route('user.dorm-info') }}"
                                    class="text-green-600 font-bold hover:underline">Info
                                    Kos</a>.
                            </p>
                        </div>

                        <div class="relative">
                            <select name="payment_method" id="payment_method" required
                                class="block w-full rounded-xl border border-gray-200 bg-gray-100 px-4 py-2.5 text-sm text-gray-600 cursor-not-allowed appearance-none">
                                <option value="bank_transfer" selected>Transfer Bank (Hanya Metode Ini)</option>
                            </select>
                        </div>

                        @error('payment_method')
                            <x-input-error :messages="[$message]" />
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">
                            Deskripsi / Keterangan
                            <span class="text-gray-400 font-normal">(opsional)</span>
                        </label>
                        <textarea name="description" id="description" rows="3"
                            placeholder="Contoh: Pembayaran sewa kamar bulan Januari 2025"
                            class="block w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-900 focus:ring-2 focus:ring-green-500 focus:border-green-500 focus:bg-white transition @error('description') border-red-400 bg-red-50 @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <x-input-error :messages="[$message]" />
                        @enderror
                    </div>

                    {{-- Proof Upload --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Bukti Pembayaran <span class="text-red-500">*</span>
                        </label>
                        <div id="upload-zone"
                            class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-200 border-dashed rounded-xl bg-gray-50 hover:border-green-400 hover:bg-green-50 transition cursor-pointer @error('proof_file') border-red-400 bg-red-50 @enderror"
                            onclick="document.getElementById('proof_file').click()">

                            <div id="upload-placeholder" class="space-y-2 text-center">
                                <svg class="mx-auto h-10 w-10 text-gray-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="text-sm text-gray-500 font-medium">Klik untuk pilih file bukti pembayaran</p>
                                <p class="text-xs text-gray-400">PNG, JPG, PDF hingga 2MB</p>
                            </div>

                            {{-- Preview --}}
                            <img id="proof-preview" src="#" alt="Preview"
                                class="hidden max-h-48 rounded-lg object-contain mx-auto" />
                            <div id="proof-pdf-badge" class="hidden flex-col items-center justify-center gap-2 py-4">
                                <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <p id="proof-pdf-name" class="text-sm text-gray-700 font-semibold text-center"></p>
                                <p class="text-xs text-gray-400">PDF siap diupload</p>
                            </div>
                        </div>
                        <input type="file" name="proof_file" id="proof_file" accept=".jpg,.jpeg,.png,.pdf" required
                            class="hidden">
                        @error('proof_file')
                            <x-input-error :messages="[$message]" />
                        @enderror
                    </div>

                    {{-- Info Banner --}}
                    <div class="flex items-start gap-3 p-4 bg-blue-50 border border-blue-100 rounded-xl">
                        <div
                            class="flex-shrink-0 w-8 h-8 bg-blue-500 rounded-xl flex items-center justify-center shadow-sm mt-0.5">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="text-sm text-blue-800 space-y-1">
                            <p class="font-bold">Panduan Upload</p>
                            <ul class="space-y-0.5 font-medium text-blue-700">
                                <li>• Pastikan foto struk/screenshot transfer terlihat jelas</li>
                                <li>• Nominal harus sesuai dengan jumlah tagihan</li>
                                <li>• Verifikasi dilakukan oleh admin dalam <strong>1×24 jam</strong></li>
                            </ul>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex justify-end gap-3 pt-2">
                        <a href="{{ route('user.payments') }}"
                            class="px-5 py-2.5 border border-gray-300 rounded-xl text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 transition">
                            Batal
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-6 py-2.5 border border-transparent rounded-xl shadow text-sm font-bold text-white bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 transform hover:scale-105 transition-all duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            Upload Bukti Pembayaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const proofInput = document.getElementById('proof_file');
        const uploadZone = document.getElementById('upload-zone');
        const placeholder = document.getElementById('upload-placeholder');
        const previewImg = document.getElementById('proof-preview');
        const pdfBadge = document.getElementById('proof-pdf-badge');
        const pdfName = document.getElementById('proof-pdf-name');

        proofInput.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;

            const isPdf = file.type === 'application/pdf';
            placeholder.classList.add('hidden');

            if (isPdf) {
                previewImg.classList.add('hidden');
                pdfBadge.classList.remove('hidden');
                pdfBadge.classList.add('flex');
                pdfName.textContent = file.name;
            } else {
                pdfBadge.classList.add('hidden');
                pdfBadge.classList.remove('flex');
                const reader = new FileReader();
                reader.onload = e => {
                    previewImg.src = e.target.result;
                    previewImg.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }

            uploadZone.classList.add('border-green-400', 'bg-green-50');
            uploadZone.classList.remove('border-gray-200', 'bg-gray-50');
        });
    </script>
@endsection