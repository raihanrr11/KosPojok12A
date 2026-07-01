<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Kos Pojok 12A') }} — Auth</title>
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-50">
  <div class="min-h-screen grid place-items-center relative overflow-hidden">
    <!-- subtle bg -->
    <div class="pointer-events-none absolute inset-0">
      <div class="absolute -top-32 -left-32 h-96 w-96 rounded-full blur-3xl opacity-20 bg-indigo-200"></div>
      <div class="absolute -bottom-32 -right-32 h-96 w-96 rounded-full blur-3xl opacity-20 bg-sky-200"></div>
    </div>

    <!-- brand header -->
    <a href="https://web.whatsapp.com/" target="_blank"
      class="absolute top-6 left-6 text-gray-900 font-semibold tracking-tight">
      <span class="inline-block px-2 py-1 rounded-lg bg-[#2BD5BB] text-gray-900 mr-2 shadow-sm">KP</span>
      Kos Pojok 12A
    </a>

    <main class="w-full max-w-5xl px-4 sm:px-6 lg:px-8">
      @yield('content')
    </main>

    <footer class="absolute bottom-6 text-[10px] font-black text-gray-400 tracking-[0.2em] uppercase">
      &copy; {{ date('Y') }} Kos Pojok 12A. All Rights Reserved.
    </footer>
  </div>
</body>

</html>yield('content')
</main>

<footer class="absolute bottom-6 text-[10px] font-black text-gray-400 tracking-[0.2em] uppercase">
  &copy; {{ date('Y') }} Kos Pojok 12A. All Rights Reserved.
</footer>
</div>
</body>

</html>