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

            <!-- Spanduk Informasi Darurat (Alert Banner Card) -->
            <div
                class="mt-6 bg-red-50 border border-red-200 rounded-xl p-4 shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-start gap-3">
                    <div
                        class="flex-shrink-0 w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center border border-red-200 text-red-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-red-950">Mengalami Kendala Darurat / Mendesak?</h4>
                        <p class="text-xs text-red-700 mt-0.5 leading-relaxed">
                            Jika Anda menghadapi situasi darurat yang butuh penanganan segera (seperti air bocor parah,
                            korsleting listrik, kunci rusak/hilang, atau masalah lainnya), maka segera hubungi Admin
                            langsung
                            via WhatsApp.
                        </p>
                    </div>
                </div>
                <div class="flex-shrink-0">
                    <a href="{{ route('whatsapp.redirect', 'emergency') }}" target="_blank"
                        class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 transition-all duration-300">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                        </svg>
                        Hubungi Sekarang!
                    </a>
                </div>
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