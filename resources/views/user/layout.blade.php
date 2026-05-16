<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Pusat Informasi</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-sans antialiased bg-kos-cream">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation (sticky) -->
        <nav class="sticky top-0 z-50 bg-kos-mint border-b border-kos-teal/30 shadow-md" x-data="{ mobileOpen: false }">
            <div class="max-w-[1440px] mx-auto px-6 lg:px-12">
                <div class="flex justify-between h-[80px]">
                    <div class="flex">
                        <!-- Brand -->
                        <div class="shrink-0 flex items-center">
                            <a href="{{ route('user.dashboard') }}" class="flex items-center space-x-2 group">
                                <div
                                    class="w-8 h-8 bg-gradient-to-br from-indigo-600 to-purple-700 rounded-lg flex items-center justify-center shadow transform group-hover:rotate-6 transition-transform duration-300">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <span class="text-lg font-black text-black tracking-tight">
                                    Kos Pojok 12A
                                </span>
                            </a>
                        </div>

                        <!-- Links (desktop) -->
                        <div class="hidden space-x-1 sm:ml-8 sm:flex sm:items-center">
                            <a href="{{ route('user.dashboard') }}"
                                class="inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-all duration-150 {{ request()->routeIs('user.dashboard*') ? 'bg-black text-white' : 'text-black' }} hover:text-white hover:bg-black group">
                                <svg class="w-4 h-4 mr-1.5 {{ request()->routeIs('user.dashboard*') ? 'text-white' : 'text-black' }} group-hover:text-white"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                </svg>
                                Pusat Informasi
                            </a>
                            <a href="{{ route('user.payments') }}"
                                class="inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-all duration-150 {{ request()->routeIs(['user.payments*', 'user.payment*']) ? 'bg-black text-white' : 'text-black' }} hover:text-white hover:bg-black group">
                                <svg class="w-4 h-4 mr-1.5 {{ request()->routeIs(['user.payments*', 'user.payment*']) ? 'text-white' : 'text-black' }} group-hover:text-white"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Pembayaran
                            </a>
                            <a href="{{ route('user.complaints') }}"
                                class="inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-all duration-150 {{ request()->routeIs('user.complaints*') ? 'bg-black text-white' : 'text-black' }} hover:text-white hover:bg-black group">
                                <svg class="w-4 h-4 mr-1.5 {{ request()->routeIs('user.complaints*') ? 'text-white' : 'text-black' }} group-hover:text-white"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                Keluhan
                            </a>
                            <a href="{{ route('user.dorm-info') }}"
                                class="inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-all duration-150 {{ request()->routeIs('user.dorm-info') ? 'bg-black text-white' : 'text-black' }} hover:text-white hover:bg-black group">
                                <svg class="w-4 h-4 mr-1.5 {{ request()->routeIs('user.dorm-info') ? 'text-white' : 'text-black' }} group-hover:text-white"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                Info Kos
                            </a>
                        </div>
                    </div>

                    <!-- Profile Dropdown (desktop) -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        @auth
                            @php $u = auth()->user(); @endphp
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open"
                                    class="flex items-center space-x-2 px-3 py-2 rounded-xl hover:bg-gray-50 transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-indigo-300">
                                    @if($u->photo)
                                        <img class="h-9 w-9 rounded-full object-cover ring-2 ring-indigo-200 shadow-sm"
                                            src="{{ \Illuminate\Support\Str::startsWith($u->photo, ['http://', 'https://']) ? $u->photo : Storage::url($u->photo) }}"
                                            alt="{{ $u->name }}">
                                    @else
                                        <div
                                            class="h-9 w-9 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center ring-2 ring-indigo-200 shadow-sm">
                                            <span class="text-sm font-bold text-white">{{ substr($u->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                    <div class="text-left hidden lg:block">
                                        <p class="text-sm font-semibold text-black leading-tight">{{ $u->name }}</p>
                                        <p class="text-xs text-black/60 leading-tight">Penghuni</p>
                                    </div>
                                    <svg class="w-4 h-4 text-gray-400 transition-transform duration-200"
                                        :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <!-- Dropdown -->
                                <div x-show="open" @click.away="open = false"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 scale-95"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-95"
                                    class="absolute right-0 mt-2 w-56 rounded-2xl bg-kos-cream shadow-2xl ring-1 ring-black ring-opacity-5 z-50 overflow-hidden"
                                    style="display: none;">

                                    <!-- User Info Header -->
                                    <div class="px-4 py-4 bg-gradient-to-br from-indigo-600 to-purple-600">
                                        <div class="flex items-center space-x-3">
                                            @if($u->photo)
                                                <img class="h-10 w-10 rounded-full object-cover ring-2 ring-white/50"
                                                    src="{{ \Illuminate\Support\Str::startsWith($u->photo, ['http://', 'https://']) ? $u->photo : Storage::url($u->photo) }}"
                                                    alt="{{ $u->name }}">
                                            @else
                                                <div
                                                    class="h-10 w-10 rounded-full bg-white/20 flex items-center justify-center ring-2 ring-white/50">
                                                    <span
                                                        class="text-sm font-bold text-white">{{ substr($u->name, 0, 1) }}</span>
                                                </div>
                                            @endif
                                            <div class="min-w-0">
                                                <p class="text-sm font-bold text-white truncate">{{ $u->name }}</p>
                                                <p class="text-xs text-indigo-200 truncate">{{ $u->email }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="py-1.5">
                                        <a href="{{ route('user.profile') }}"
                                            class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-colors duration-100">
                                            <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            Profil Saya
                                        </a>

                                        <div class="my-1 border-t border-gray-100"></div>

                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit"
                                                class="w-full flex items-center px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors duration-100">
                                                <svg class="w-4 h-4 mr-3 text-red-400" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                                </svg>
                                                Logout
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endauth
                    </div>

                    <!-- Hamburger (mobile) -->
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button @click="mobileOpen = !mobileOpen"
                            class="inline-flex items-center justify-center p-2 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 focus:outline-none transition duration-150">
                            <svg x-show="!mobileOpen" class="h-6 w-6" stroke="currentColor" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <svg x-show="mobileOpen" class="h-6 w-6" stroke="currentColor" fill="none"
                                viewBox="0 0 24 24" style="display:none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="mobileOpen" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2"
                class="sm:hidden border-t border-gray-100 bg-kos-cream" style="display: none;">
                <div class="pt-2 pb-3 px-3 space-y-1">
                    <a href="{{ route('user.dashboard') }}"
                        class="flex items-center px-3 py-2.5 rounded-xl {{ request()->routeIs('user.dashboard*') ? 'bg-black text-white font-semibold' : 'text-black hover:bg-black hover:text-white' }} text-sm font-medium transition duration-150 group">
                        <svg class="w-4 h-4 mr-2.5 {{ request()->routeIs('user.dashboard*') ? 'text-white' : 'text-black' }} group-hover:text-white"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        Pusat Informasi
                    </a>
                    <a href="{{ route('user.payments') }}"
                        class="flex items-center px-3 py-2.5 rounded-xl {{ request()->routeIs(['user.payments*', 'user.payment*']) ? 'bg-black text-white font-semibold' : 'text-black hover:bg-black hover:text-white' }} text-sm font-medium transition duration-150 group">
                        <svg class="w-4 h-4 mr-2.5 {{ request()->routeIs(['user.payments*', 'user.payment*']) ? 'text-white' : 'text-black' }} group-hover:text-white"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Pembayaran
                    </a>
                    <a href="{{ route('user.complaints') }}"
                        class="flex items-center px-3 py-2.5 rounded-xl {{ request()->routeIs('user.complaints*') ? 'bg-black text-white font-semibold' : 'text-black hover:bg-black hover:text-white' }} text-sm font-medium transition duration-150 group">
                        <svg class="w-4 h-4 mr-2.5 {{ request()->routeIs('user.complaints*') ? 'text-white' : 'text-black' }} group-hover:text-white"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        Keluhan
                    </a>
                    <a href="{{ route('user.dorm-info') }}"
                        class="flex items-center px-3 py-2.5 rounded-xl {{ request()->routeIs('user.dorm-info') ? 'bg-black text-white font-semibold' : 'text-black hover:bg-black hover:text-white' }} text-sm font-medium transition duration-150 group">
                        <svg class="w-4 h-4 mr-2.5 {{ request()->routeIs('user.dorm-info') ? 'text-white' : 'text-black' }} group-hover:text-white"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        Info Kos
                    </a>
                </div>

                @auth
                    @php $u = auth()->user(); @endphp
                    <div class="pt-3 pb-3 border-t border-gray-100">
                        <div class="flex items-center px-4 py-2">
                            @if($u->photo)
                                <img class="h-10 w-10 rounded-full object-cover ring-2 ring-indigo-200"
                                    src="{{ \Illuminate\Support\Str::startsWith($u->photo, ['http://', 'https://']) ? $u->photo : Storage::url($u->photo) }}"
                                    alt="{{ $u->name }}">
                            @else
                                <div
                                    class="h-10 w-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center ring-2 ring-indigo-200">
                                    <span class="text-sm font-bold text-white">{{ substr($u->name, 0, 1) }}</span>
                                </div>
                            @endif
                            <div class="ml-3">
                                <div class="font-semibold text-sm text-gray-800">{{ $u->name }}</div>
                                <div class="text-xs text-gray-500 truncate">{{ $u->email }}</div>
                            </div>
                        </div>

                        <div class="mt-1 px-3 space-y-1">
                            <a href="{{ route('user.profile') }}"
                                class="flex items-center px-3 py-2.5 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-800 transition duration-150">
                                <svg class="w-4 h-4 mr-2.5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Profil Saya
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center px-3 py-2.5 rounded-xl text-sm font-medium text-red-600 hover:bg-red-50 transition duration-150">
                                    <svg class="w-4 h-4 mr-2.5 text-red-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>
        </nav>

        <!-- Page Content -->
        <main>
            {{-- Flash Messages --}}
            @if (session('success') || session('error') || $errors->any())
                <div class="pt-6 pb-2 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    @if (session('success'))
                        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                            class="mb-4 flex items-center p-4 bg-green-50 border border-green-100 rounded-2xl shadow-sm">
                            <div class="flex-shrink-0 w-9 h-9 bg-green-500 rounded-xl flex items-center justify-center shadow">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <p class="ml-3 text-sm font-semibold text-green-800 flex-1">{{ session('success') }}</p>
                            <button @click="show = false" class="text-green-400 hover:text-green-600 ml-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                            class="mb-4 flex items-center p-4 bg-red-50 border border-red-100 rounded-2xl shadow-sm">
                            <div class="flex-shrink-0 w-9 h-9 bg-red-500 rounded-xl flex items-center justify-center shadow">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="ml-3 text-sm font-semibold text-red-800 flex-1">{{ session('error') }}</p>
                            <button @click="show = false" class="text-red-400 hover:text-red-600 ml-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-50 border border-red-100 rounded-2xl shadow-sm">
                            <div class="flex items-start">
                                <div
                                    class="flex-shrink-0 w-9 h-9 bg-red-500 rounded-xl flex items-center justify-center shadow">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <ul class="ml-3 text-sm text-red-700 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            {{-- Main Content --}}
            @yield('content')
        </main>

        <!-- Footer / Copyright Bar -->
        <footer class="bg-kos-dark border-t border-kos-mint/10 py-12 mt-auto mt-20">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="flex flex-col md:flex-row items-center justify-between gap-8">
                    <div class="flex items-center space-x-4">
                        <div
                            class="w-10 h-10 bg-kos-mint rounded-xl flex items-center justify-center shadow-lg shadow-kos-mint/20">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div>
                            <span class="block text-sm font-black text-white tracking-[0.2em] uppercase">Kos Pojok
                                12A</span>
                            <span
                                class="block text-[10px] font-bold text-kos-mint/60 tracking-widest uppercase mt-0.5">Premium
                                Living Space</span>
                        </div>
                    </div>

                    <div class="text-center md:text-right">
                        <p class="text-[11px] font-black text-gray-500 tracking-[0.15em] uppercase leading-relaxed">
                            &copy; {{ date('Y') }} <span class="text-kos-mint">Kos Pojok 12A</span>.
                            <br class="md:hidden">
                            All Rights Reserved.
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>

</html>