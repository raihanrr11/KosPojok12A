@extends('user.layout')

@section('content')
    <div class="space-y-8 pb-12">
        <!-- Premium Hero Header -->
        <div class="relative overflow-hidden rounded-2xl bg-[#000811] p-8 shadow-xl mx-4 sm:mx-6 lg:mx-8 mt-6">
            <!-- Decorative Elements -->
            <div class="absolute -top-12 -right-12 w-64 h-64 bg-[#2BD5BB] rounded-full mix-blend-screen filter blur-[80px] opacity-30 animate-pulse"></div>
            <div class="absolute -bottom-12 -left-12 w-64 h-64 bg-purple-600 rounded-full mix-blend-screen filter blur-[80px] opacity-30"></div>
            
            <div class="relative z-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                <div class="max-w-2xl">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-white/10 text-[#2BD5BB] text-[10px] font-black tracking-widest uppercase mb-3 backdrop-blur-md border border-white/10">
                        Papan Informasi
                    </span>
                    <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight leading-tight mb-2">
                        Keluhan <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#2BD5BB] to-teal-400">Umum Kos</span>
                    </h1>
                    <p class="text-sm text-gray-400 font-medium max-w-lg leading-relaxed">
                        Pantau transparansi dan progres perbaikan fasilitas kos bersama.
                    </p>
                </div>
                
                <div class="flex-shrink-0">
                    <a href="{{ route('user.complaints.create') }}"
                        class="group relative inline-flex items-center justify-center px-6 py-3 font-bold text-[#000811] bg-[#2BD5BB] rounded-xl overflow-hidden transition-all duration-300 hover:scale-105 hover:shadow-[0_0_30px_rgba(43,213,187,0.3)]">
                        <span class="absolute w-0 h-0 transition-all duration-500 ease-out bg-white rounded-full group-hover:w-48 group-hover:h-48 opacity-10"></span>
                        <svg class="w-4 h-4 mr-2 relative z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                        </svg>
                        <span class="relative z-10 text-sm">Ajukan Keluhan</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Soft Status Filter Bar -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 mb-8">
            <div class="bg-white rounded-[2.5rem] p-2 shadow-sm border border-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                    <!-- Pending -->
                    <a href="{{ route('user.public-complaints', ['status' => 'pending']) }}" 
                       class="flex items-center justify-between px-6 py-4 rounded-[1.75rem] transition-all duration-300 group {{ request('status') == 'pending' ? 'bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-200' : 'bg-gray-50 text-gray-400 hover:bg-amber-50 hover:text-amber-700 hover:ring-1 hover:ring-inset hover:ring-amber-200' }}">
                        <div class="flex items-center">
                            <div class="w-2 h-2 rounded-full bg-amber-500 mr-3 {{ request('status') == 'pending' ? 'animate-pulse' : 'opacity-40 group-hover:opacity-100' }}"></div>
                            <span class="text-xs font-black uppercase tracking-widest">Pending</span>
                        </div>
                        <span class="{{ request('status') == 'pending' ? 'bg-white text-amber-600 shadow-sm' : 'bg-white text-gray-400 group-hover:text-amber-600 shadow-sm' }} text-[10px] font-black px-3 py-1 rounded-xl transition-colors duration-500">{{ $counts['pending'] }}</span>
                    </a>

                    <!-- In Progress -->
                    <a href="{{ route('user.public-complaints', ['status' => 'in_progress']) }}" 
                       class="flex items-center justify-between px-6 py-4 rounded-[1.75rem] transition-all duration-300 group {{ request('status') == 'in_progress' ? 'bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-200' : 'bg-gray-50 text-gray-400 hover:bg-blue-50 hover:text-blue-700 hover:ring-1 hover:ring-inset hover:ring-blue-200' }}">
                        <div class="flex items-center">
                            <div class="w-2 h-2 rounded-full bg-blue-600 mr-3 {{ request('status') == 'in_progress' ? 'animate-pulse' : 'opacity-40 group-hover:opacity-100' }}"></div>
                            <span class="text-xs font-black uppercase tracking-widest">In Progress</span>
                        </div>
                        <span class="{{ request('status') == 'in_progress' ? 'bg-white text-blue-600 shadow-sm' : 'bg-white text-gray-400 group-hover:text-blue-600 shadow-sm' }} text-[10px] font-black px-3 py-1 rounded-xl transition-colors duration-500">{{ $counts['in_progress'] }}</span>
                    </a>

                    <!-- Completed -->
                    <a href="{{ route('user.public-complaints', ['status' => 'completed']) }}" 
                       class="flex-1 flex items-center justify-between px-6 py-4 rounded-[1.75rem] transition-all duration-300 group {{ request('status') == 'completed' ? 'bg-green-50 text-green-700 ring-1 ring-inset ring-green-200' : 'bg-gray-50 text-gray-400 hover:bg-green-50 hover:text-green-700 hover:ring-1 hover:ring-inset hover:ring-green-200' }}">
                        <div class="flex items-center">
                            <div class="w-2 h-2 rounded-full bg-green-500 mr-3 {{ request('status') == 'completed' ? 'animate-pulse' : 'opacity-40 group-hover:opacity-100' }}"></div>
                            <span class="text-xs font-black uppercase tracking-widest">Completed</span>
                        </div>
                        <span class="{{ request('status') == 'completed' ? 'bg-white text-green-600 shadow-sm' : 'bg-white text-gray-400 group-hover:text-green-600 shadow-sm' }} text-[10px] font-black px-3 py-1 rounded-xl transition-colors duration-500">{{ $counts['completed'] }}</span>
                    </a>
                </div>
            </div>
            
            @if(request('status'))
                <div class="mt-4 flex justify-end">
                    <a href="{{ route('user.public-complaints') }}" class="text-sm font-bold text-gray-500 hover:text-gray-900 transition-colors flex items-center bg-white px-4 py-2 rounded-lg shadow-sm border border-gray-100">
                        <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Tampilkan Semua
                    </a>
                </div>
            @endif
        </div>

        <!-- Complaints Grid -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($complaints as $complaint)
                    <a href="{{ route('user.public-complaint-show', $complaint) }}" 
                       class="group block bg-white rounded-3xl p-6 shadow-sm hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 border border-gray-100 flex flex-col h-full relative overflow-hidden">
                        
                        <!-- Hover Gradient Effect -->
                        <div class="absolute inset-0 bg-gradient-to-br from-[#2BD5BB]/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        
                        <div class="relative z-10 flex-1 flex flex-col">
                            <!-- Header / Badges -->
                            <div class="flex items-start justify-between mb-5">
                                @if($complaint->status === 'resolved')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-50 text-green-600 border border-green-200 shadow-sm">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1.5 animate-pulse"></span> Selesai
                                    </span>
                                @elseif($complaint->status === 'in_progress')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-600 border border-blue-200 shadow-sm">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-1.5 animate-pulse"></span> Diproses
                                    </span>
                                @elseif($complaint->status === 'closed')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gray-50 text-gray-600 border border-gray-200 shadow-sm">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-500 mr-1.5"></span> Ditutup
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-600 border border-amber-200 shadow-sm">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5 animate-pulse"></span> Menunggu
                                    </span>
                                @endif

                                @if($complaint->priority === 'high')
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-red-50 text-red-500 border border-red-100 shadow-sm" title="Prioritas Tinggi">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                    </span>
                                @endif
                            </div>

                            <!-- Content -->
                            <h3 class="text-lg font-black text-gray-900 group-hover:text-[#1D9E75] transition-colors duration-300 mb-2 line-clamp-2">
                                {{ $complaint->subject }}
                            </h3>
                            <p class="text-sm text-gray-500 leading-relaxed mb-6 line-clamp-3 flex-1">
                                {{ $complaint->description }}
                            </p>

                            <!-- Footer (Author & Date) -->
                            <div class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-gray-800 to-[#000811] flex items-center justify-center text-white text-xs font-bold shadow-sm">
                                        {{ substr($complaint->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-gray-900">{{ $complaint->user->name }}</p>
                                        <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider">{{ $complaint->category_label }}</p>
                                    </div>
                                </div>
                                <div class="text-[11px] font-bold text-gray-400 bg-gray-50 px-2.5 py-1 rounded-lg">
                                    {{ $complaint->created_at->format('d M') }}
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <!-- Premium Empty State -->
                    <div class="col-span-full">
                        <div class="bg-white rounded-3xl p-12 text-center shadow-sm border border-gray-100 relative overflow-hidden">
                            <div class="absolute -top-24 -right-24 w-64 h-64 bg-[#2BD5BB]/10 rounded-full mix-blend-multiply opacity-50"></div>
                            <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-blue-50 rounded-full mix-blend-multiply opacity-50"></div>
                            
                            <div class="relative z-10 flex flex-col items-center">
                                <div class="w-24 h-24 mb-6 rounded-3xl bg-gradient-to-br from-[#2BD5BB]/20 to-teal-100 flex items-center justify-center transform rotate-3">
                                    <svg class="w-12 h-12 text-[#1D9E75]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-black text-gray-900 mb-2">Semua Aman Terkendali!</h3>
                                <p class="text-gray-500 font-medium max-w-md mx-auto">Saat ini belum ada keluhan umum yang dilaporkan oleh penghuni. Fasilitas kos berjalan dengan baik.</p>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($complaints->hasPages())
                <div class="mt-10 flex justify-center">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-2 inline-block">
                        {{ $complaints->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection