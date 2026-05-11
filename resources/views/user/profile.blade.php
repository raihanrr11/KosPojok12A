@extends('user.layout')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    {{-- Hero Profile Header --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-indigo-600 via-purple-600 to-violet-700 p-8 shadow-xl">
        <div class="absolute -top-16 -right-16 w-64 h-64 bg-white/10 rounded-full blur-2xl"></div>
        <div class="absolute -bottom-16 -left-16 w-64 h-64 bg-white/5 rounded-full blur-2xl"></div>

        <div class="relative z-10 flex flex-col sm:flex-row sm:items-center gap-6">
            {{-- Avatar --}}
            <div class="flex-shrink-0">
                @if($user->photo)
                    <img class="h-24 w-24 rounded-2xl object-cover ring-4 ring-white/30 shadow-lg"
                        src="{{ Storage::url($user->photo) }}" alt="{{ $user->name }}">
                @else
                    <div class="h-24 w-24 rounded-2xl bg-white/20 backdrop-blur-sm ring-4 ring-white/30 shadow-lg flex items-center justify-center">
                        <span class="text-4xl font-black text-white">{{ substr($user->name, 0, 1) }}</span>
                    </div>
                @endif
            </div>

            {{-- Info --}}
            <div class="flex-1 min-w-0">
                <h1 class="text-2xl font-black text-white truncate">{{ $user->name }}</h1>
                <p class="text-indigo-200 text-sm mt-0.5">{{ $user->email }}</p>
                <div class="flex flex-wrap items-center gap-2 mt-3">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 text-white text-xs font-bold backdrop-blur-sm">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        Akun Aktif
                    </span>
                    @if($user->room_number)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 text-white text-xs font-bold backdrop-blur-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Kamar {{ $user->room_number }}
                        </span>
                    @endif
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 text-white text-xs font-bold backdrop-blur-sm">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Bergabung {{ $user->created_at->format('d F Y') }}
                    </span>
                </div>
            </div>

            {{-- Edit Button --}}
            <div class="flex-shrink-0">
                <a href="{{ route('profile.edit') }}"
                    class="inline-flex items-center px-5 py-2.5 rounded-xl bg-white/20 hover:bg-white/30 text-white text-sm font-bold backdrop-blur-sm border border-white/20 transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                    Ubah Password
                </a>
            </div>
        </div>
    </div>

    {{-- Detail Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Personal Info Card --}}
        <div class="bg-white rounded-xl shadow-md overflow-hidden md:col-span-2">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white flex items-center gap-3">
                <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <h2 class="text-base font-bold text-gray-800">Informasi Pribadi</h2>
            </div>

            <dl class="divide-y divide-gray-100">
                {{-- Name --}}
                <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="flex items-center gap-2 text-sm font-semibold text-gray-500">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Nama Lengkap
                    </dt>
                    <dd class="mt-1 sm:mt-0 sm:col-span-2 text-sm font-bold text-gray-900">{{ $user->name }}</dd>
                </div>

                {{-- Email --}}
                <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="flex items-center gap-2 text-sm font-semibold text-gray-500">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                        </svg>
                        Email
                    </dt>
                    <dd class="mt-1 sm:mt-0 sm:col-span-2 text-sm text-gray-900">{{ $user->email }}</dd>
                </div>

                {{-- Phone --}}
                <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="flex items-center gap-2 text-sm font-semibold text-gray-500">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        Nomor Telepon
                    </dt>
                    <dd class="mt-1 sm:mt-0 sm:col-span-2 text-sm font-semibold text-gray-900">
                        {{ $user->phone ?? '—' }}
                    </dd>
                </div>

                {{-- Room --}}
                <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="flex items-center gap-2 text-sm font-semibold text-gray-500">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Nomor Kamar
                    </dt>
                    <dd class="mt-1 sm:mt-0 sm:col-span-2">
                        @if($user->room_number)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-indigo-100 text-indigo-800">
                                Kamar {{ $user->room_number }}
                            </span>
                        @else
                            <span class="text-sm text-gray-400 italic">Belum ada kamar</span>
                        @endif
                    </dd>
                </div>

                {{-- Address --}}
                <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="flex items-center gap-2 text-sm font-semibold text-gray-500">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Alamat
                    </dt>
                    <dd class="mt-1 sm:mt-0 sm:col-span-2 text-sm text-gray-700">
                        {{ $user->address ?? '—' }}
                    </dd>
                </div>
            </dl>
        </div>
    </div>

    {{-- Info Notice --}}
    <div class="flex items-start gap-3 p-4 bg-blue-50 border border-blue-100 rounded-xl">
        <div class="flex-shrink-0 w-8 h-8 bg-blue-500 rounded-xl flex items-center justify-center shadow-sm mt-0.5">
            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                    clip-rule="evenodd"/>
            </svg>
        </div>
        <p class="text-sm text-blue-800 font-medium">
            <strong class="font-bold">Informasi:</strong> Jika ada data yang perlu diperbarui (nama, nomor kamar, dll), silakan hubungi admin atau pengelola kos secara langsung.
        </p>
    </div>

    {{-- Footer Action --}}
    <div class="flex justify-center">
        <a href="{{ route('user.dashboard') }}"
            class="inline-flex items-center px-5 py-2.5 border border-gray-300 rounded-xl text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 shadow-sm transition">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Pusat Informasi
        </a>
    </div>
</div>
@endsection