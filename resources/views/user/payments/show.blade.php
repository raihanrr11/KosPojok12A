@extends('user.layout')

@section('content')
    <div style="background: var(--color-background-tertiary, #FFF9EB); min-height: 100vh; padding-bottom: 48px;">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

            {{-- Header with Amount --}}
            <div
                class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 p-8 shadow-xl">
                <div class="relative z-10 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <h1 class="text-3xl font-black text-white">
                            Rp {{ number_format($payment->amount, 0, ',', '.') }}
                        </h1>
                        <p class="mt-1 text-green-100 text-sm">
                            Detail Pembayaran #{{ $payment->id }} &bull; {{ $payment->payment_date->format('d F Y') }}
                        </p>
                    </div>

                    {{-- Status Badge --}}
                    <div class="mt-4 sm:mt-0">
                        @if($payment->status === 'verified')
                            <span
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold bg-white text-green-700 shadow-sm">
                                <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                Terverifikasi
                            </span>
                        @elseif($payment->status === 'rejected')
                            <span
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold bg-white text-red-600 shadow-sm">
                                <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd" />
                                </svg>
                                Ditolak
                            </span>
                        @else
                            <span
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold bg-white text-yellow-600 shadow-sm">
                                <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                        clip-rule="evenodd" />
                                </svg>
                                Menunggu Verifikasi
                            </span>
                        @endif
                    </div>
                </div>
                <div class="absolute top-0 right-0 -mt-4 -mr-4 h-28 w-28 rounded-full bg-white opacity-10"></div>
                <div class="absolute bottom-0 left-0 -mb-6 -ml-6 h-36 w-36 rounded-full bg-white opacity-5"></div>
            </div>

            {{-- Status Banner --}}
            @if($payment->status === 'pending')
                <div class="flex items-start gap-4 p-5 bg-yellow-50 border border-yellow-200 rounded-2xl shadow-sm">
                    <div
                        class="flex-shrink-0 w-11 h-11 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-xl flex items-center justify-center shadow-md">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-bold text-yellow-800">Menunggu Verifikasi Admin</p>
                        <p class="text-xs text-yellow-700 mt-1 font-medium">Bukti pembayaran Anda sedang ditinjau. Proses
                            verifikasi
                            biasanya membutuhkan waktu <strong>1×24 jam</strong>.</p>
                    </div>
                </div>

            @elseif($payment->status === 'rejected')
                <div class="flex items-start gap-4 p-5 bg-red-50 border border-red-200 rounded-2xl shadow-sm">
                    <div
                        class="flex-shrink-0 w-11 h-11 bg-gradient-to-br from-red-500 to-pink-600 rounded-xl flex items-center justify-center shadow-md">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-bold text-red-800">Pembayaran Ditolak</p>
                        <p class="text-xs text-red-700 mt-1 font-medium">Bukti pembayaran Anda tidak dapat diverifikasi. Silakan
                            unggah ulang dengan foto yang lebih jelas atau hubungi admin.</p>
                        <a href="{{ route('user.payments.create') }}"
                            class="inline-flex items-center mt-3 px-4 py-2 bg-red-600 text-white text-xs font-bold rounded-lg hover:bg-red-700 transition">
                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            Upload Ulang Bukti
                        </a>
                    </div>
                </div>

            @else
                <div class="flex items-start gap-4 p-5 bg-green-50 border border-green-200 rounded-2xl shadow-sm">
                    <div
                        class="flex-shrink-0 w-11 h-11 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-md">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-bold text-green-800">Pembayaran Terverifikasi</p>
                        <p class="text-xs text-green-700 mt-1 font-medium">
                            Selamat! Pembayaran Anda telah berhasil diverifikasi oleh admin.
                            @if($payment->verified_at)
                                Diverifikasi pada <strong>{{ $payment->verified_at->format('d F Y, H:i') }}</strong>.
                            @endif
                        </p>
                    </div>
                </div>
            @endif

            {{-- Detail Card --}}
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                    <h2 class="text-base font-bold text-gray-800">Informasi Pembayaran</h2>
                </div>

                <dl class="divide-y divide-gray-100">
                    {{-- Amount --}}
                    <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-semibold text-gray-500">Jumlah Pembayaran</dt>
                        <dd class="mt-1 sm:mt-0 sm:col-span-2 text-lg font-black text-gray-900">
                            Rp {{ number_format($payment->amount, 0, ',', '.') }}
                        </dd>
                    </div>

                    {{-- Date --}}
                    <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-semibold text-gray-500">Tanggal Pembayaran</dt>
                        <dd class="mt-1 sm:mt-0 sm:col-span-2 text-sm font-semibold text-gray-900">
                            {{ $payment->payment_date->format('d F Y') }}
                        </dd>
                    </div>

                    {{-- Method --}}
                    <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-semibold text-gray-500">Metode Pembayaran</dt>
                        <dd class="mt-1 sm:mt-0 sm:col-span-2">
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-indigo-100 text-indigo-800">
                                {{ ucwords(str_replace('_', ' ', $payment->payment_method)) }}
                            </span>
                        </dd>
                    </div>

                    {{-- Description --}}
                    @if($payment->description)
                        <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-semibold text-gray-500">Keterangan</dt>
                            <dd class="mt-1 sm:mt-0 sm:col-span-2 text-sm text-gray-700">{{ $payment->description }}</dd>
                        </div>
                    @endif

                    {{-- Upload Date --}}
                    <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-semibold text-gray-500">Tanggal Upload</dt>
                        <dd class="mt-1 sm:mt-0 sm:col-span-2 text-sm font-semibold text-gray-900">
                            {{ $payment->created_at->format('d F Y, H:i') }}
                        </dd>
                    </div>

                    {{-- Admin Notes on Rejection --}}
                    @if($payment->status === 'rejected' && $payment->admin_notes)
                        <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-semibold text-gray-500">Alasan Penolakan</dt>
                            <dd class="mt-1 sm:mt-0 sm:col-span-2">
                                <div class="flex items-start gap-3 p-3 bg-red-50 border border-red-100 rounded-xl">
                                    <svg class="w-4 h-4 text-red-500 flex-shrink-0 mt-0.5" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <p class="text-sm font-medium text-red-700">{{ $payment->admin_notes }}</p>
                                </div>
                            </dd>
                        </div>
                    @endif

                    {{-- Proof File --}}
                    @if($payment->proof_file)
                        <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-semibold text-gray-500">Bukti Pembayaran</dt>
                            <dd class="mt-1 sm:mt-0 sm:col-span-2">
                                @if(Str::endsWith($payment->proof_file, ['.jpg', '.jpeg', '.png']))
                                    <img src="{{ Storage::url($payment->proof_file) }}" alt="Bukti Pembayaran"
                                        class="max-w-sm rounded-xl border border-gray-200 shadow-sm cursor-pointer hover:opacity-90 transition"
                                        onclick="this.classList.toggle('max-w-sm'); this.classList.toggle('max-w-full')">
                                    <p class="text-xs text-gray-400 mt-1 font-medium">Klik gambar untuk memperbesar</p>
                                @else
                                    <a href="{{ Storage::url($payment->proof_file) }}" target="_blank"
                                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold rounded-xl transition">
                                        <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Lihat Bukti Pembayaran (PDF)
                                    </a>
                                @endif
                            </dd>
                        </div>
                    @endif
                </dl>
            </div>

            {{-- Actions --}}
            <div class="flex justify-center gap-4">
                <a href="{{ route('user.payments') }}"
                    class="inline-flex items-center px-5 py-2.5 border border-gray-300 rounded-xl text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 shadow-sm transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Riwayat
                </a>

                @if($payment->status === 'rejected')
                    <a href="{{ route('user.payments.create') }}"
                        class="inline-flex items-center px-6 py-2.5 rounded-xl shadow text-sm font-bold text-white bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 transform hover:scale-105 transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        Upload Ulang
                    </a>
                @endif
            </div>
        </div>
    </div>
@endsection