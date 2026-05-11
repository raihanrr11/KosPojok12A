<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Kos Pojok 12A') }} — Registrasi</title>
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link
    href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800|playfair-display:400i,700,700i|space-grotesk:300,400,500,600&display=swap"
    rel="stylesheet" />
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <style>
    .bg-dormitory {
      background-image: url('/images/dorm-bg.jpg');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
    }
  </style>
</head>

<body class="antialiased bg-gray-900 text-white h-screen overflow-hidden flex relative bg-dormitory"
  style="font-family: 'Plus Jakarta Sans', sans-serif;">
  <div class="absolute inset-0 bg-black/60 backdrop-blur-sm z-0"></div>

  <div class="relative z-10 flex w-full h-screen">

    <!-- Left Side: Register Info -->
    <div
      class="w-full lg:w-[450px] xl:w-[500px] bg-white/10 backdrop-blur-xl border-r border-white/20 p-8 sm:p-12 flex flex-col h-full overflow-y-auto custom-scrollbar shadow-[10px_0_30px_rgba(0,0,0,0.5)]">

      <!-- Brand Header -->
      <a href="/" style="font-family: 'Space Grotesk', sans-serif; letter-spacing: -0.3px;"
        class="flex items-center text-white font-bold text-2xl tracking-tight mb-10 hover:opacity-80 transition">
        <span
          class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-[#2BD5BB] text-gray-900 mr-3 shadow-lg">KP</span>
        Kos Pojok 12A
      </a>

      <div class="flex-1 flex flex-col justify-center">
        <h1 class="text-4xl font-bold text-white mb-4" style="font-family: 'Playfair Display', serif;">
          <em style="font-style: italic; color: #2BD5BB;">Registrasi</em> Penghuni
        </h1>
        <p class="text-gray-300 text-sm mb-8 leading-relaxed">
          Selamat datang di Kos Pojok 12A. Saat ini pendaftaran akun dilakukan secara manual oleh Admin untuk menjaga
          keamanan dan kenyamanan penghuni.
        </p>

        <div class="bg-indigo-500/10 border border-indigo-500/30 p-6 rounded-2xl mb-8 backdrop-blur-md">
          <h2 class="text-xs font-bold text-indigo-300 uppercase mb-5 flex items-center"
            style="font-family: 'Space Grotesk', sans-serif; letter-spacing: 1px;">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Panduan Ringkas
          </h2>
          <ul class="space-y-4 text-gray-200 text-sm">
            <li class="flex items-start">
              <span
                class="flex-shrink-0 flex items-center justify-center w-6 h-6 rounded-full bg-indigo-500/20 text-indigo-300 font-bold mr-3 border border-indigo-500/30">1</span>
              <span>Siapkan Nama Lengkap, Foto Diri, dan No. HP aktif.</span>
            </li>
            <li class="flex items-start">
              <span
                class="flex-shrink-0 flex items-center justify-center w-6 h-6 rounded-full bg-indigo-500/20 text-indigo-300 font-bold mr-3 border border-indigo-500/30">2</span>
              <span>Tentukan kamar yang ingin Anda huni.</span>
            </li>
            <li class="flex items-start">
              <span
                class="flex-shrink-0 flex items-center justify-center w-6 h-6 rounded-full bg-indigo-500/20 text-indigo-300 font-bold mr-3 border border-indigo-500/30">3</span>
              <span>Kirim data tersebut melalui chat WhatsApp ke Admin.</span>
            </li>
          </ul>
        </div>

        <a href="https://web.whatsapp.com/" target="_blank"
          class="w-full inline-flex justify-center items-center rounded-xl bg-[#25D366] text-white px-4 py-3.5 font-bold hover:bg-[#1DA851] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-900 focus:ring-[#25D366] transition-all transform hover:scale-[1.02] shadow-lg">
          <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24">
            <path
              d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
          </svg>
          Chat Admin Sekarang
        </a>

        <p class="mt-8 text-center text-sm text-gray-400">
          Sudah punya akun?
          <a href="{{ route('login') }}"
            class="font-semibold text-[#2BD5BB] hover:text-[#23bda6] hover:underline transition">Masuk di sini</a>
        </p>
      </div>

      <footer class="mt-8 text-[10px] font-black text-white/40 tracking-[0.2em] uppercase text-center">
        &copy; {{ date('Y') }} Kos Pojok 12A. All Rights Reserved
      </footer>
    </div>

    <!-- Right Side: Visual/Feature List -->
    <div
      class="hidden lg:flex flex-1 p-12 xl:p-24 flex-col justify-center relative h-full overflow-y-auto custom-scrollbar">
      <!-- Decorational glowing orbs -->
      <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-purple-500/20 rounded-full blur-[100px] pointer-events-none">
      </div>
      <div
        class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-[#2BD5BB]/20 rounded-full blur-[100px] pointer-events-none">
      </div>

      <div class="max-w-4xl relative z-10">
        <div
          class="inline-flex items-center px-4 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white text-sm font-semibold mb-8 shadow-sm">
          <span class="flex h-2 w-2 rounded-full bg-purple-400 mr-2 animate-pulse"></span>
          Keamanan & Kenyamanan Terjamin
        </div>

        <h2 class="text-5xl xl:text-7xl font-extrabold text-white leading-tight mb-6 drop-shadow-xl"
          style="font-family: 'Playfair Display', serif; font-weight: 700;">
          Mulai Hidup<br>Nyaman<br>
          <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#2BD5BB] to-purple-400"
            style="font-style: italic;">
            Bersama Kami
          </span>
        </h2>

        <p class="text-lg xl:text-xl text-gray-200 mb-12 max-w-2xl leading-relaxed drop-shadow-md">
          Proses verifikasi manual memastikan lingkungan kos yang aman dan kondusif bagi seluruh penghuni. Kami
          memprioritaskan privasi dan kenyamanan Anda.
        </p>

        <div class="grid grid-cols-2 gap-6 max-w-3xl">
          <!-- Feature 1 -->
          <div class="bg-black/30 backdrop-blur-md border border-white/10 p-6 rounded-2xl transition duration-300">
            <div
              class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#2BD5BB] to-teal-600 flex items-center justify-center mb-5 shadow-lg">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
              </svg>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">Lingkungan Aman</h3>
            <p class="text-gray-400 text-sm leading-relaxed">Verifikasi identitas ketat untuk semua calon penghuni.</p>
          </div>

          <!-- Feature 2 -->
          <div class="bg-black/30 backdrop-blur-md border border-white/10 p-6 rounded-2xl transition duration-300">
            <div
              class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center mb-5 shadow-lg">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">Pembayaran Mudah</h3>
            <p class="text-gray-400 text-sm leading-relaxed">Akses dashboard pembayaran kapanpun & dimanapun dengan
              mudah.</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <style>
    .custom-scrollbar::-webkit-scrollbar {
      width: 6px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
      background: rgba(255, 255, 255, 0.05);
      border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
      background: rgba(255, 255, 255, 0.2);
      border-radius: 10px;
    }
  </style>
</body>

</html>