@extends('user.layout')

@section('content')
    <div style="background: var(--color-background-tertiary, #FFF9EB); min-height: 100vh; padding-bottom: 48px;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Header dengan Gradient -->
            <div
                class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 p-6 shadow-lg">
                <div class="relative z-10 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-white">Riwayat Pembayaran</h1>
                        <p class="mt-1 text-green-100 text-sm">Kelola dan pantau semua pembayaran Anda</p>
                    </div>
                    <div class="mt-4 sm:mt-0">
                        <a href="{{ route('user.payments.create') }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-md text-sm font-bold text-green-600 bg-white hover:bg-green-50 transition-all duration-300">
                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            Upload Bukti
                        </a>
                    </div>
                </div>
                <div class="absolute top-0 right-0 -mt-4 -mr-4 h-24 w-24 rounded-full bg-white opacity-10"></div>
                <div class="absolute bottom-0 left-0 -mb-6 -ml-6 h-32 w-32 rounded-full bg-white opacity-5"></div>
            </div>

            <!-- Filter Section -->
            <div class="mt-6 bg-white rounded-xl shadow-sm p-4 border border-gray-100">
                <form action="{{ route('user.payments') }}" method="GET" class="flex flex-wrap items-end gap-3">
                    <div class="flex-1 min-w-[140px]">
                        <label for="month"
                            class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5 ml-1">Bulan</label>
                        <select name="month" id="month"
                            class="block w-full rounded-lg border-gray-200 bg-gray-50 text-xs focus:ring-green-500 focus:border-green-500 transition py-2">
                            <option value="">Semua Bulan</option>
                            @for($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div class="flex-1 min-w-[100px]">
                        <label for="year"
                            class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5 ml-1">Tahun</label>
                        <select name="year" id="year"
                            class="block w-full rounded-lg border-gray-200 bg-gray-50 text-xs focus:ring-green-500 focus:border-green-500 transition py-2">
                            <option value="">Semua Tahun</option>
                            @php $currentYear = date('Y'); @endphp
                            @for($y = $currentYear; $y >= $currentYear - 5; $y--)
                                <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="flex-1 min-w-[120px]">
                        <label for="status"
                            class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5 ml-1">Status</label>
                        <select name="status" id="status"
                            class="block w-full rounded-lg border-gray-200 bg-gray-50 text-xs focus:ring-green-500 focus:border-green-500 transition py-2">
                            <option value="">Semua Status</option>
                            <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Terverifikasi
                            </option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="submit"
                            class="inline-flex items-center px-5 py-2 bg-green-600 text-white text-xs font-bold rounded-lg hover:bg-green-700 shadow-sm transition active:scale-95">
                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Filter
                        </button>
                        @if(request()->filled('month') || request()->filled('year') || request()->filled('status'))
                            <a href="{{ route('user.payments') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-500 text-xs font-bold rounded-lg hover:bg-gray-200 transition">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Payments List -->
            <div class="mt-6 bg-white rounded-2xl border border-gray-100 p-4 shadow-sm">
                <div class="space-y-3">
                    @forelse($payments as $payment)
                        <a href="{{ route('user.payments.show', $payment) }}"
                            class="group block bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-200">
                            <div class="p-4">
                                <div class="flex items-center gap-4">
                                    <!-- Compact Status Icon -->
                                    <div class="flex-shrink-0">
                                        @if($payment->status === 'verified')
                                            <div
                                                class="h-10 w-10 rounded-lg bg-green-50 flex items-center justify-center border border-green-100">
                                                <svg class="h-5 w-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        @elseif($payment->status === 'rejected')
                                            <div
                                                class="h-10 w-10 rounded-lg bg-red-50 flex items-center justify-center border border-red-100">
                                                <svg class="h-5 w-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        @else
                                            <div
                                                class="h-10 w-10 rounded-lg bg-yellow-50 flex items-center justify-center border border-yellow-100">
                                                <svg class="h-5 w-5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Payment Core Info -->
                                    <div class="flex-1 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                                        <div>
                                            <h3
                                                class="text-lg font-bold text-gray-900 group-hover:text-green-600 transition-colors">
                                                Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                            </h3>
                                            <div class="flex items-center gap-3 mt-0.5">
                                                <span
                                                    class="text-xs text-gray-500 font-medium">{{ $payment->payment_date->format('d M Y') }}</span>
                                                <span class="text-[10px] text-gray-300">•</span>
                                                <span
                                                    class="text-xs text-gray-500 font-medium">{{ ucfirst($payment->payment_method) }}</span>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-3">
                                            <!-- Status Badge Compact -->
                                            @if($payment->status === 'verified')
                                                <span
                                                    class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-green-100 text-green-700">Terverifikasi</span>
                                            @elseif($payment->status === 'rejected')
                                                <span
                                                    class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-red-100 text-red-700">Ditolak</span>
                                            @else
                                                <span
                                                    class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-yellow-100 text-yellow-700">Pending</span>
                                            @endif

                                            <svg class="w-4 h-4 text-gray-300 group-hover:text-green-600 transform group-hover:translate-x-1 transition-all"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <!-- Empty State -->
                        <div class="bg-white rounded-xl shadow-md overflow-hidden">
                            <div class="px-4 py-16 text-center">
                                <div
                                    class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-br from-green-100 to-emerald-100 mb-4">
                                    <svg class="w-10 h-10 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Riwayat Pembayaran</h3>
                                <p class="text-gray-600">Mulai dengan mengupload bukti pembayaran pertama Anda melalui tombol di
                                    atas
                                </p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            @if($payments->hasPages())
                <div class="bg-white rounded-xl shadow-md px-4 py-3">
                    {{ $payments->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection