<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sistem Manajemen Kos</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 selection:bg-red-500 selection:text-white">
            @if (Route::has('login'))
                <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="max-w-7xl mx-auto p-6 lg:p-8">
                <div class="flex justify-center">
                    <h1 class="text-6xl font-bold text-gray-900">
                        Sistem Manajemen Kos
                    </h1>
                </div>

                <div class="mt-16">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                        <div class="scale-100 p-6 bg-white from-gray-700/50 via-transparent rounded-lg shadow-2xl shadow-gray-500/20 ring-1 ring-inset ring-gray-900/5 transition-all duration-250">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900">
                                    Untuk Admin
                                </h2>
                                <p class="mt-4 text-gray-500 text-sm leading-relaxed">
                                    Kelola penghuni kos, pembayaran, dan keluhan dengan mudah melalui dashboard admin.
                                </p>
                                @guest
                                <div class="mt-4">
                                    <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Login Admin
                                    </a>
                                </div>
                                @endguest
                            </div>
                        </div>

                        <div class="scale-100 p-6 bg-white from-gray-700/50 via-transparent rounded-lg shadow-2xl shadow-gray-500/20 ring-1 ring-inset ring-gray-900/5 transition-all duration-250">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900">
                                    Untuk Penghuni
                                </h2>
                                <p class="mt-4 text-gray-500 text-sm leading-relaxed">
                                    Kirim pembayaran, ajukan keluhan, dan pantau status pembayaran Anda.
                                </p>
                                @guest
                                <div class="mt-4 space-x-2">
                                    <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Login
                                    </a>
                                    @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Register
                                    </a>
                                    @endif
                                </div>
                                @endguest
                            </div>
                        </div>
                    </div>
                </div>

                @guest
                <div class="mt-16 flex justify-center">
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-blue-900 mb-4">Akun Testing:</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div class="bg-white p-4 rounded border">
                                <h4 class="font-semibold text-gray-900">Admin</h4>
                                <p class="text-gray-600">Email: admin@kos.com</p>
                                <p class="text-gray-600">Password: password</p>
                            </div>
                            <div class="bg-white p-4 rounded border">
                                <h4 class="font-semibold text-gray-900">User</h4>
                                <p class="text-gray-600">Email: user@kos.com</p>
                                <p class="text-gray-600">Password: password</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endguest
            </div>
        </div>
    </body>
</html>