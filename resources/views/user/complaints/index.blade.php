@extends('user.layout')

@section('content')
    <div style="background: var(--color-background-tertiary, #FFF9EB); min-height: 100vh; padding-bottom: 48px;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Header dengan Gradient -->
            <div
                class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-rose-600 via-red-600 to-rose-500 p-6 shadow-lg">
                <div class="relative z-10 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-white">Keluhan Saya</h1>
                        <p class="mt-1 text-red-100 text-sm">Kelola dan pantau semua keluhan Anda</p>
                    </div>
                    <div class="mt-4 sm:mt-0">
                        <a href="{{ route('user.complaints.create') }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-md text-sm font-bold text-red-600 bg-white hover:bg-red-50 transition-all duration-300">
                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            Ajukan Keluhan
                        </a>
                    </div>
                </div>
                <div class="absolute top-0 right-0 -mt-4 -mr-4 h-24 w-24 rounded-full bg-white opacity-10"></div>
                <div class="absolute bottom-0 left-0 -mb-6 -ml-6 h-32 w-32 rounded-full bg-white opacity-5"></div>
            </div>

            <!-- Filter Section -->
            <div class="mt-6 bg-white rounded-xl shadow-sm p-4 border border-gray-100">
                <form action="{{ route('user.complaints') }}" method="GET" class="flex flex-wrap items-end gap-3">
                    <div class="flex-1 min-w-[140px]">
                        <label for="month"
                            class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5 ml-1">Bulan</label>
                        <select name="month" id="month"
                            class="block w-full rounded-lg border-gray-200 bg-gray-50 text-xs focus:ring-red-500 focus:border-red-500 transition py-2">
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
                            class="block w-full rounded-lg border-gray-200 bg-gray-50 text-xs focus:ring-red-500 focus:border-red-500 transition py-2">
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
                        <label for="visibility"
                            class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5 ml-1">Visibilitas</label>
                        <select name="visibility" id="visibility"
                            class="block w-full rounded-lg border-gray-200 bg-gray-50 text-xs focus:ring-red-500 focus:border-red-500 transition py-2">
                            <option value="">Semua</option>
                            <option value="public" {{ request('visibility') == 'public' ? 'selected' : '' }}>Publik</option>
                            <option value="private" {{ request('visibility') == 'private' ? 'selected' : '' }}>Pribadi
                            </option>
                        </select>
                    </div>

                    <div class="flex-1 min-w-[120px]">
                        <label for="status"
                            class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5 ml-1">Status</label>
                        <select name="status" id="status"
                            class="block w-full rounded-lg border-gray-200 bg-gray-50 text-xs focus:ring-red-500 focus:border-red-500 transition py-2">
                            <option value="">Semua Status</option>
                            <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Menunggu</option>
                            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>Proses
                            </option>
                            <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Selesai</option>
                            <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Ditutup</option>
                        </select>
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="submit"
                            class="inline-flex items-center px-5 py-2 bg-red-600 text-white text-xs font-bold rounded-lg hover:bg-red-700 shadow-sm transition active:scale-95">
                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Filter
                        </button>
                        @if(request()->filled('month') || request()->filled('year') || request()->filled('visibility') || request()->filled('status'))
                            <a href="{{ route('user.complaints') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-500 text-xs font-bold rounded-lg hover:bg-gray-200 transition">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Complaints List -->
            <div class="mt-6 bg-white rounded-2xl border border-gray-100 p-4 shadow-sm">
                <div class="space-y-3">
                    @forelse($complaints as $complaint)
                        <a href="{{ route('user.complaints.show', $complaint) }}"
                            class="group block bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-200">
                            <div class="p-4">
                                <div class="flex items-center gap-4">
                                    <!-- Compact Status Icon -->
                                    <div class="flex-shrink-0">
                                        @if($complaint->status === 'resolved')
                                            <div
                                                class="h-10 w-10 rounded-lg bg-green-50 flex items-center justify-center border border-green-100">
                                                <svg class="h-5 w-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        @elseif($complaint->status === 'in_progress')
                                            <div
                                                class="h-10 w-10 rounded-lg bg-blue-50 flex items-center justify-center border border-blue-100">
                                                <svg class="h-5 w-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        @else
                                            <div
                                                class="h-10 w-10 rounded-lg bg-red-50 flex items-center justify-center border border-red-100">
                                                <svg class="h-5 w-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Complaint Core Info -->
                                    <div class="flex-1 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                                        <div class="min-w-0">
                                            <h3
                                                class="text-base font-bold text-gray-900 group-hover:text-red-600 transition-colors truncate">
                                                {{ $complaint->subject }}
                                            </h3>
                                            <div class="flex flex-wrap items-center gap-x-3 gap-y-1 mt-0.5">
                                                <span
                                                    class="text-[11px] text-gray-500 font-medium">{{ $complaint->created_at->format('d M Y') }}</span>
                                                <span class="text-[10px] text-gray-300">•</span>
                                                <span
                                                    class="text-[11px] text-gray-500 font-medium">{{ $complaint->category_label }}</span>
                                                <span class="text-[10px] text-gray-300">•</span>
                                                <span
                                                    class="text-[11px] text-gray-500 font-medium">{{ $complaint->priority_label }}</span>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-3">
                                            <!-- Status Badge Compact -->
                                            @if($complaint->status === 'resolved')
                                                <span
                                                    class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-green-100 text-green-700 whitespace-nowrap">Selesai</span>
                                            @elseif($complaint->status === 'in_progress')
                                                <span
                                                    class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-700 whitespace-nowrap">Proses</span>
                                            @elseif($complaint->status === 'closed')
                                                <span
                                                    class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-gray-100 text-gray-700 whitespace-nowrap">Ditutup</span>
                                            @else
                                                <span
                                                    class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-red-100 text-red-700 whitespace-nowrap">Menunggu</span>
                                            @endif

                                            <svg class="w-4 h-4 text-gray-300 group-hover:text-red-600 transform group-hover:translate-x-1 transition-all"
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
                                    class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-br from-red-100 to-pink-100 mb-4">
                                    <svg class="w-10 h-10 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Keluhan</h3>
                                <p class="text-gray-600 mb-6">Mulai dengan mengajukan keluhan pertama melalui tombol di atas
                                    jika
                                    ada masalah</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            @if($complaints->hasPages())
                <div class="bg-white rounded-xl shadow-md px-4 py-3">
                    {{ $complaints->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection