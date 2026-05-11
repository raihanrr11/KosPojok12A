@extends('user.layout')

@section('content')
<div class="max-w-3xl mx-auto space-y-6 pb-12">

    {{-- Header --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-red-600 via-pink-600 to-purple-600 p-8 shadow-xl">
        <div class="relative z-10 sm:flex sm:items-start sm:justify-between">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <p class="text-sm font-medium text-red-200">Keluhan #{{ $complaint->id }}</p>
                    {{-- Status badge next to the ID --}}
                    @if($complaint->status === 'resolved')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-400/30 text-green-100 border border-green-300/40">✓ Selesai</span>
                    @elseif($complaint->status === 'in_progress')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-yellow-400/30 text-yellow-100 border border-yellow-300/40">⏳ Diproses</span>
                    @elseif($complaint->status === 'closed')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-400/30 text-gray-100 border border-gray-300/40">✕ Ditutup</span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-white/20 text-white border border-white/30">● Menunggu</span>
                    @endif
                </div>
                <h1 class="text-2xl font-bold text-white leading-tight">{{ $complaint->subject }}</h1>
                <p class="mt-1 text-red-100 text-sm">{{ $complaint->category_label }} &mdash; {{ $complaint->created_at->format('d F Y, H:i') }}</p>
            </div>
            {{-- Visibility & Priority badges only --}}
            <div class="mt-4 sm:mt-0 flex flex-wrap gap-2">
                @if($complaint->is_public)
                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-green-900/40 text-green-100 border border-green-400/40">🌐 Publik</span>
                @else
                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-white/10 text-white border border-white/20">🔒 Pribadi</span>
                @endif

                @if($complaint->priority === 'high')
                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-red-900/50 text-red-100 border border-red-400/40">↑ Prioritas Tinggi</span>
                @elseif($complaint->priority === 'medium')
                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-yellow-900/40 text-yellow-100 border border-yellow-400/40">Prioritas Sedang</span>
                @else
                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-white/10 text-white border border-white/20">Prioritas Rendah</span>
                @endif
            </div>
        </div>
        <div class="absolute top-0 right-0 -mt-4 -mr-4 h-32 w-32 rounded-full bg-white opacity-10"></div>
        <div class="absolute bottom-0 left-0 -mb-8 -ml-8 h-40 w-40 rounded-full bg-white opacity-5"></div>
    </div>

    {{-- Detail Card --}}
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
            <h2 class="text-base font-bold text-gray-800">Detail Keluhan</h2>
        </div>
        <div class="divide-y divide-gray-100">
            {{-- Meta --}}
            <div class="p-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-gradient-to-br from-purple-50 to-pink-50 p-4 rounded-xl">
                    <p class="text-xs text-purple-600 font-bold mb-1">Kategori</p>
                    <p class="text-sm font-bold text-gray-900">{{ $complaint->category_label }}</p>
                </div>
                <div class="bg-gradient-to-br from-orange-50 to-red-50 p-4 rounded-xl">
                    <p class="text-xs text-orange-600 font-bold mb-1">Prioritas</p>
                    <p class="text-sm font-bold text-gray-900">{{ $complaint->priority_label }}</p>
                </div>
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-4 rounded-xl">
                    <p class="text-xs text-indigo-600 font-bold mb-1">Tanggal Diajukan</p>
                    <p class="text-sm font-bold text-gray-900">{{ $complaint->created_at->format('d M Y') }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">{{ $complaint->created_at->diffForHumans() }}</p>
                </div>
            </div>

            {{-- Description --}}
            <div class="p-6">
                <h3 class="text-sm font-bold text-gray-700 mb-3">Deskripsi Keluhan</h3>
                <div class="bg-gradient-to-br from-gray-50 to-gray-100 p-4 rounded-xl">
                    <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">{{ $complaint->description }}</p>
                </div>
            </div>

            {{-- Complaint Photo --}}
            @if($complaint->photo)
            <div class="p-6">
                <h3 class="text-sm font-bold text-gray-700 mb-3">Foto Pendukung</h3>
                <a href="{{ Storage::url($complaint->photo) }}" target="_blank">
                    <img src="{{ Storage::url($complaint->photo) }}" alt="Foto Keluhan"
                         class="max-h-72 rounded-xl border border-gray-200 object-contain shadow-sm hover:opacity-90 transition cursor-zoom-in">
                </a>
            </div>
            @endif

            {{-- Admin Response --}}
            @if($complaint->admin_response)
            <div class="p-6">
                <h3 class="text-sm font-bold text-gray-700 mb-3">Respon Admin</h3>
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-4 rounded-xl border-l-4 border-indigo-500">
                    <p class="text-xs font-bold text-indigo-600 mb-2">Respon dari Admin</p>
                    <p class="text-sm text-gray-700 leading-relaxed">{{ $complaint->admin_response }}</p>
                    @if($complaint->responded_at)
                    <p class="mt-3 pt-3 border-t border-indigo-200 text-xs text-indigo-500">
                        Direspon pada {{ $complaint->responded_at->format('d F Y, H:i') }}
                    </p>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- Timeline --}}
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
            <h2 class="text-base font-bold text-gray-800">Timeline Status</h2>
        </div>
        <div class="p-6">
            <ul class="-mb-8">
                <li>
                    <div class="relative pb-8">
                        @if($complaint->status !== 'open')
                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200"></span>
                        @endif
                        <div class="relative flex space-x-3">
                            <span class="h-8 w-8 rounded-full bg-gradient-to-br from-blue-500 to-indigo-500 flex items-center justify-center ring-4 ring-white shadow-sm">
                                <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/></svg>
                            </span>
                            <div class="min-w-0 flex-1 pt-1 flex justify-between space-x-4">
                                <p class="text-sm font-semibold text-gray-800">Keluhan diajukan</p>
                                <p class="text-xs text-gray-500 whitespace-nowrap">{{ $complaint->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </li>
                @if(in_array($complaint->status, ['in_progress','resolved','closed']))
                <li>
                    <div class="relative pb-8">
                        @if(in_array($complaint->status, ['resolved','closed']))
                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200"></span>
                        @endif
                        <div class="relative flex space-x-3">
                            <span class="h-8 w-8 rounded-full bg-gradient-to-br from-yellow-500 to-orange-500 flex items-center justify-center ring-4 ring-white shadow-sm">
                                <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                            </span>
                            <div class="min-w-0 flex-1 pt-1 flex justify-between space-x-4">
                                <p class="text-sm font-semibold text-gray-800">Sedang diproses</p>
                                <p class="text-xs text-gray-500 whitespace-nowrap">{{ $complaint->responded_at?->format('d M Y, H:i') ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </li>
                @endif
                @if($complaint->status === 'resolved')
                <li>
                    <div class="relative">
                        <div class="relative flex space-x-3">
                            <span class="h-8 w-8 rounded-full bg-gradient-to-br from-green-500 to-emerald-500 flex items-center justify-center ring-4 ring-white shadow-sm">
                                <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            </span>
                            <div class="min-w-0 flex-1 pt-1 flex justify-between space-x-4">
                                <p class="text-sm font-semibold text-gray-800">Keluhan selesai</p>
                                <p class="text-xs text-gray-500 whitespace-nowrap">{{ $complaint->responded_at?->format('d M Y, H:i') ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </li>
                @elseif($complaint->status === 'closed')
                <li>
                    <div class="relative">
                        <div class="relative flex space-x-3">
                            <span class="h-8 w-8 rounded-full bg-gradient-to-br from-gray-400 to-gray-500 flex items-center justify-center ring-4 ring-white shadow-sm">
                                <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                            </span>
                            <div class="min-w-0 flex-1 pt-1 flex justify-between space-x-4">
                                <p class="text-sm font-semibold text-gray-800">Keluhan ditutup</p>
                                <p class="text-xs text-gray-500 whitespace-nowrap">{{ $complaint->responded_at?->format('d M Y, H:i') ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </li>
                @endif
            </ul>
        </div>
    </div>


    {{-- Status Banner --}}
    @if($complaint->status === 'open')
    <div class="bg-gradient-to-r from-red-50 to-pink-50 border border-red-200 rounded-xl p-5">
        <div class="flex items-start gap-3">
            <svg class="h-5 w-5 text-red-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
            <div>
                <h3 class="text-sm font-bold text-red-800">Menunggu Tanggapan Admin</h3>
                <p class="mt-1 text-sm text-red-700">Keluhan Anda sudah diterima dan akan segera ditanggapi oleh admin.</p>
            </div>
        </div>
    </div>
    @elseif($complaint->status === 'in_progress')
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-5">
        <div class="flex items-start gap-3">
            <svg class="h-5 w-5 text-blue-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
            <div>
                <h3 class="text-sm font-bold text-blue-800">Keluhan Sedang Diproses</h3>
                <p class="mt-1 text-sm text-blue-700">Admin sedang menangani keluhan Anda.</p>
            </div>
        </div>
    </div>
    @elseif($complaint->status === 'resolved')
    <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl p-5">
        <div class="flex items-start gap-3">
            <svg class="h-5 w-5 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            <div>
                <h3 class="text-sm font-bold text-green-800">Keluhan Telah Selesai</h3>
                <p class="mt-1 text-sm text-green-700">Keluhan Anda telah berhasil diselesaikan.</p>
            </div>
        </div>
    </div>
    @elseif($complaint->status === 'closed')
    <div class="bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200 rounded-xl p-5">
        <div class="flex items-start gap-3">
            <svg class="h-5 w-5 text-gray-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
            <div>
                <h3 class="text-sm font-bold text-gray-800">Keluhan Ditutup</h3>
                <p class="mt-1 text-sm text-gray-700">Keluhan ini telah ditutup oleh admin.</p>
            </div>
        </div>
    </div>
    @endif

    {{-- Actions --}}
    <div class="flex flex-wrap justify-center gap-3">
        <a href="{{ route('user.complaints') }}"
           class="inline-flex items-center px-5 py-2.5 border border-gray-300 shadow-sm text-sm font-bold rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition-all duration-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Daftar
        </a>
        @if(in_array($complaint->status, ['closed','resolved']))
        <a href="{{ route('user.complaints.create') }}"
           class="inline-flex items-center px-5 py-2.5 border border-transparent shadow-sm text-sm font-bold rounded-xl text-white bg-gradient-to-r from-red-600 to-pink-600 hover:from-red-700 hover:to-pink-700 transform hover:scale-105 transition-all duration-300">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Ajukan Keluhan Baru
        </a>
        @endif
    </div>
</div>

@endsection