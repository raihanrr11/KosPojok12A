<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth m-0 p-0">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin Panel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link
        href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800|playfair-display:400i,700,700i|space-grotesk:300,400,500,600&display=swap"
        rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js CDN (Fallback) -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Alpine.js Cloak & Custom Light Theme with Login Brand Accents -->
    <style>
        [x-cloak] {
            display: none !important;
        }

        /* =========================
       GLOBAL
    ========================= */
        body {
            background-color: #f8fafc !important;
            color: #0f172a !important;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* =========================
       DARK SIDEBAR
    ========================= */
        aside {
            background: linear-gradient(180deg,
                    #06202B 0%,
                    #0B2C38 45%,
                    #04161D 100%) !important;

            border-right: 1px solid rgba(255, 255, 255, 0.06) !important;

            box-shadow:
                6px 0 24px rgba(0, 0, 0, 0.18),
                inset -1px 0 0 rgba(255, 255, 255, 0.04) !important;
        }

        /* =========================
       HEADER
    ========================= */
        header {
            background-color: #0B2C38 !important;
            backdrop-filter: blur(10px) !important;
            -webkit-backdrop-filter: blur(10px) !important;
            border-bottom: 1px solid #e2e8f0 !important;
        }

        /* =========================
       MAIN
    ========================= */
        main.bg-gray-50,
        main {
            background-color: transparent !important;
        }

        /* =========================
       CARD
    ========================= */
        .bg-white {
            background-color: #ffffff !important;
            border: 1px solid #e2e8f0 !important;

            box-shadow:
                0 4px 6px -1px rgba(0, 0, 0, 0.03),
                0 2px 4px -1px rgba(0, 0, 0, 0.02) !important;
        }

        .bg-gray-50 {
            background-color: #f8fafc !important;
        }

        /* =========================
       BORDERS
    ========================= */
        .border-gray-100,
        .border-gray-200,
        .border-gray-300,
        .divide-gray-100,
        .divide-gray-200 {
            border-color: #e2e8f0 !important;
            divide-color: #e2e8f0 !important;
        }

        /* =========================
       TEXT COLORS
    ========================= */
        .text-gray-900 {
            color: #0f172a !important;
        }

        .text-gray-800 {
            color: #1e293b !important;
        }

        .text-gray-700 {
            color: #334155 !important;
        }

        .text-gray-600 {
            color: #475569 !important;
        }

        .text-gray-500 {
            color: #64748b !important;
        }

        .text-gray-400 {
            color: #94a3b8 !important;
        }

        /* =========================
       SIDEBAR TEXT
    ========================= */
        aside .text-black,
        aside .text-gray-900 {
            color: #ffffff !important;
        }

        aside .text-gray-600 {
            color: #94A3B8 !important;
        }

        aside .text-gray-400 {
            color: #64748B !important;
        }

        aside .border-gray-100 {
            border-color: rgba(255, 255, 255, 0.06) !important;
        }

        /* NAVIGATION */
        aside nav a {
            transition: all 0.25s ease;
            color: #94A3B8 !important;
        }

        /* Hover */
        aside nav a:hover {
            background: rgba(43, 213, 187, 0.08) !important;
            color: #ffffff !important;
            transform: translateX(2px);
        }

        aside nav a:hover svg {
            color: #2BD5BB !important;
        }

        /* Active menu */
        aside nav a.bg-gradient-to-r.from-indigo-50 {
            background: linear-gradient(90deg,
                    rgba(43, 213, 187, 0.18),
                    rgba(43, 213, 187, 0.08)) !important;

            color: #2BD5BB !important;
            border-left: 4px solid #2BD5BB !important;
            border-radius: 0 14px 14px 0 !important;
            box-shadow:
                inset 0 1px 0 rgba(255, 255, 255, 0.04),
                0 4px 14px rgba(43, 213, 187, 0.12);
            backdrop-filter: blur(10px);
        }

        aside nav a.bg-gradient-to-r.from-indigo-50 svg {
            color: #2BD5BB !important;
        }

        /* =========================
       BUTTONS
    ========================= */

        /* Secondary */
        a[class*="bg-white border-gray-300"],
        button[class*="bg-white border-gray-300"],
        .bg-white.py-2.px-4.border.border-gray-300 {
            background-color: #ffffff !important;
            border-color: #cbd5e1 !important;
            color: #475569 !important;
        }

        a[class*="bg-white border-gray-300"]:hover,
        button[class*="bg-white border-gray-300"]:hover,
        .bg-white.py-2.px-4.border.border-gray-300:hover {
            background-color: #f8fafc !important;
            color: #0f172a !important;
        }

        /* Primary */
        .bg-indigo-600,
        .bg-indigo-700,
        button[type="submit"]:not(.bg-red-600),
        a[href*="create"][class*="bg-white"],
        a[class*="text-indigo-600 bg-white"] {
            background: #2BD5BB !important;
            color: #06202B !important;
            font-weight: 700 !important;
            border: none !important;

            box-shadow:
                0 4px 12px rgba(43, 213, 187, 0.25) !important;
        }

        .bg-indigo-600:hover,
        .bg-indigo-700:hover,
        button[type="submit"]:not(.bg-red-600):hover,
        a[href*="create"][class*="bg-white"]:hover,
        a[class*="text-indigo-600 bg-white"]:hover {
            background: #23bda6 !important;
            transform: scale(1.02);

            box-shadow:
                0 6px 16px rgba(43, 213, 187, 0.35) !important;
        }

        .bg-indigo-600 svg,
        .bg-indigo-700 svg,
        button[type="submit"] svg,
        a[href*="create"] svg,
        a[class*="text-indigo-600 bg-white"] svg {
            color: #06202B !important;
        }

        /* =========================
       LOGOUT BUTTON
    ========================= */
        aside button[type="submit"] {
            background: linear-gradient(135deg,
                    #2BD5BB,
                    #20B8A2) !important;

            color: #06202B !important;

            font-weight: 700 !important;

            box-shadow:
                0 8px 20px rgba(43, 213, 187, 0.25) !important;
        }

        aside button[type="submit"]:hover {
            transform: translateY(-1px);

            box-shadow:
                0 12px 24px rgba(43, 213, 187, 0.35) !important;
        }

        /* =========================
       GRADIENT HEADER
    ========================= */
        .bg-gradient-to-r.from-indigo-600,
        .bg-gradient-to-br.from-indigo-600,
        .bg-gradient-to-br.from-indigo-500 {
            background-image: linear-gradient(135deg,
                    #077A7D,
                    #06202B) !important;

            border: none !important;
            color: #ffffff !important;

            box-shadow:
                0 4px 15px rgba(7, 122, 125, 0.15) !important;
        }

        .bg-gradient-to-r.from-indigo-600 h1,
        .bg-gradient-to-br.from-indigo-600 h1,
        .bg-gradient-to-br.from-indigo-500 h1 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: #ffffff !important;
        }

        .text-indigo-100 {
            color: #e2e8f0 !important;
        }

        /* =========================
       SECTION HEADER
    ========================= */
        .bg-gradient-to-r.from-indigo-50.to-purple-50,
        .bg-gradient-to-r.from-blue-50.to-cyan-50,
        .bg-gradient-to-r.from-green-50.to-emerald-50,
        .bg-gradient-to-r.from-red-50.to-pink-50,
        .bg-gradient-to-r.from-yellow-50.to-orange-50 {
            background-image: linear-gradient(to right,
                    #f8fafc,
                    #f1f5f9) !important;

            border-bottom: 1px solid #e2e8f0 !important;
        }

        /* =========================
       INPUT
    ========================= */
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="number"],
        input[type="date"],
        select,
        textarea {
            background-color: #ffffff !important;
            border: 1px solid #cbd5e1 !important;
            color: #0f172a !important;
            border-radius: 12px !important;

            transition: all 0.2s ease-in-out !important;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="number"]:focus,
        input[type="date"]:focus,
        select:focus,
        textarea:focus {
            background-color: #ffffff !important;
            border-color: #077A7D !important;

            --tw-ring-color: #077A7D !important;

            box-shadow:
                0 0 0 2px rgba(7, 122, 125, 0.15) !important;
        }

        /* =========================
       TABLE
    ========================= */
        table,
        thead,
        tbody,
        tr,
        th,
        td {
            background-color: transparent !important;
        }

        tr {
            border-bottom: 1px solid #f1f5f9 !important;
        }

        tr:hover {
            background-color: #f8fafc !important;
        }

        th {
            background-color: #f8fafc !important;
            color: #475569 !important;
            border-bottom: 2px solid #e2e8f0 !important;
        }

        /* =========================
       MODAL
    ========================= */
        .relative.bg-white.rounded-3xl {
            background-color: #ffffff !important;
            border: 1px solid #e2e8f0 !important;

            box-shadow:
                0 25px 50px -12px rgba(0, 0, 0, 0.1) !important;
        }

        /* =========================
       COPYRIGHT
    ========================= */
        aside p {
            color: #64748B !important;
        }

        /* =========================
       SCROLLBAR
    ========================= */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f8fafc;
        }

        ::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #475569;
        }
    </style>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="font-sans antialiased bg-slate-50 text-slate-900 m-0 p-0"
    style="font-family: 'Plus Jakarta Sans', sans-serif;" x-data="{ sidebarOpen: false }">
    <div class="flex h-screen overflow-hidden">

        <!-- Mobile Sidebar Backdrop -->
        <div x-show="sidebarOpen" class="fixed inset-0 z-40 bg-gray-900/50 backdrop-blur-sm lg:hidden"
            @click="sidebarOpen = false" x-transition.opacity></div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 w-64 transition-transform duration-300 lg:translate-x-0 lg:static lg:w-72 flex flex-col">
            <!-- Sidebar Header -->
            <div class="h-20 flex items-center justify-between px-6 border-b border-gray-100">
                <a href="{{ route('admin.dashboard') }}"
                    style="font-family: 'Space Grotesk', sans-serif; letter-spacing: -0.3px;"
                    class="group flex items-center space-x-3 hover:opacity-80 transition">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-[#2BD5BB] to-[#20B8A2] text-[#06202B] font-extrabold rounded-xl flex items-center justify-center shadow-lg transform group-hover:rotate-12 transition-transform duration-300">
                        KP
                    </div>
                    <span class="text-lg font-black text-white tracking-tight">
                        Kos Pojok 12A
                    </span>
                </a>
                <button @click="sidebarOpen = false"
                    class="lg:hidden text-gray-400 hover:text-gray-600 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- Sidebar Navigation -->
            <nav class="flex-1 overflow-y-auto px-4 py-6 space-y-2">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-indigo-50 to-purple-50 text-indigo-700 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 font-medium' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-indigo-600' : 'text-gray-400' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('admin.users') }}"
                    class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.users*') ? 'bg-gradient-to-r from-indigo-50 to-purple-50 text-indigo-700 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 font-medium' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.users*') ? 'text-indigo-600' : 'text-gray-400' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span>Penghuni</span>
                </a>

                <a href="{{ route('admin.payments') }}"
                    class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.payments*') ? 'bg-gradient-to-r from-indigo-50 to-purple-50 text-indigo-700 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 font-medium' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.payments*') ? 'text-indigo-600' : 'text-gray-400' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Pembayaran</span>
                </a>

                <a href="{{ route('admin.complaints') }}"
                    class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.complaints*') ? 'bg-gradient-to-r from-indigo-50 to-purple-50 text-indigo-700 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 font-medium' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.complaints*') ? 'text-indigo-600' : 'text-gray-400' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <span>Keluhan</span>
                </a>

                <a href="{{ route('admin.rooms.index') }}"
                    class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.rooms*') ? 'bg-gradient-to-r from-indigo-50 to-purple-50 text-indigo-700 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 font-medium' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.rooms*') ? 'text-indigo-600' : 'text-gray-400' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span>Kamar</span>
                </a>

                <a href="{{ route('admin.settings') }}"
                    class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.settings*') ? 'bg-gradient-to-r from-indigo-50 to-purple-50 text-indigo-700 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 font-medium' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.settings*') ? 'text-indigo-600' : 'text-gray-400' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span>Informasi Kos</span>
                </a>
            </nav>

            <!-- Sidebar Footer -->
            <div class="p-4 border-t border-gray-100 space-y-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center space-x-2 px-4 py-3 bg-red-50 text-red-600 hover:bg-red-100 rounded-xl font-bold transition-colors duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span>Logout</span>
                    </button>
                </form>

                <p class="text-[8px] text-center text-gray-400 font-bold tracking-widest uppercase px-2">
                    &copy; {{ date('Y') }} Kos Pojok 12A. All Rights Reserved
                </p>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Top Header -->
            <header
                class="bg-white/80 backdrop-blur-md border-b border-gray-100 h-20 flex items-center justify-between px-4 sm:px-6 lg:px-8 z-30">
                <div class="flex items-center">
                    <button @click="sidebarOpen = true"
                        class="lg:hidden p-2 mr-3 text-gray-400 hover:text-indigo-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <!-- Breadcrumbs or page title could go here -->
                </div>

                <div class="flex items-center space-x-4">
                    <!-- User Profile Display -->
                    <div class="flex items-center space-x-3">
                        <div class="text-right hidden sm:block">
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Admin Kos</p>
                            <p class="text-sm font-bold text-gray-200">
                                Admin {{ \App\Models\Setting::get('dorm_name', 'Kos Pojok 12A') }}
                            </p>
                        </div>
                        <div
                            class="w-10 h-10 rounded-xl bg-[#2BD5BB] text-gray-900 font-black shadow-md cursor-default flex items-center justify-center">
                            A
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Scrollable Area -->
            <main class="flex-1 overflow-y-auto bg-gray-50 px-4 pb-4 sm:px-6 sm:pb-6 lg:px-8 lg:pb-8 pt-0">
                <!-- Flash Messages -->
                @if (session('success'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                        class="mb-6 flex items-center p-4 bg-green-50 border border-green-100 rounded-2xl shadow-sm">
                        <div
                            class="flex-shrink-0 w-10 h-10 bg-green-500 rounded-xl flex items-center justify-center shadow-md">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-sm font-bold text-green-800">{{ session('success') }}</p>
                        </div>
                        <button @click="show = false" class="text-green-400 hover:text-green-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                        class="mb-6 flex items-center p-4 bg-red-50 border border-red-100 rounded-2xl shadow-sm">
                        <div
                            class="flex-shrink-0 w-10 h-10 bg-red-500 rounded-xl flex items-center justify-center shadow-md">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-sm font-bold text-red-800">{{ session('error') }}</p>
                        </div>
                        <button @click="show = false" class="text-red-400 hover:text-red-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                @endif

                <!-- Content Area -->
                <div class="max-w-7xl mx-auto">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>

</html>