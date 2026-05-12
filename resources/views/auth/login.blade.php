<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Kos Pojok 12A') }} — Masuk</title>
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link
    href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800|playfair-display:400i,700,700i|space-grotesk:300,400,500,600&display=swap"
    rel="stylesheet" />
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

  <style>
    /* Background class where user will add their dormitory image later */
    .bg-dormitory {
      background-image: url('/images/dorm-bg.jpg');
      /* Ganti dengan path gambar asrama Anda */
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      background-attachment: fixed;
    }

    @keyframes shake {

      0%,
      100% {
        transform: translateX(0);
      }

      10%,
      30%,
      50%,
      70%,
      90% {
        transform: translateX(-5px);
      }

      20%,
      40%,
      60%,
      80% {
        transform: translateX(5px);
      }
    }

    .animate-shake {
      animation: shake 0.5s ease-in-out;
    }

    [x-cloak] {
      display: none !important;
    }

    /* Hide browser's native password reveal/clear buttons to avoid duplication */
    input::-ms-reveal,
    input::-ms-clear {
      display: none;
    }
  </style>
</head>

<body class="antialiased bg-gray-900 text-white min-h-screen overflow-x-hidden flex relative bg-dormitory"
  style="font-family: 'Plus Jakarta Sans', sans-serif;">
  <!-- Overlay to adjust background opacity and ensure good contrast -->
  <!-- Sesuaikan opacity (black/60, black/70, dll) sesuai kebutuhan kontras -->
  <div class="fixed inset-0 bg-black/60 backdrop-blur-sm z-0"></div>

  <!-- Main Layout Container -->
  <div class="relative z-10 flex flex-col lg:flex-row w-full min-h-screen">

    <!-- Left Side: Login Form (Glassmorphism / Solid Effect) -->
    <div
      class="w-full lg:w-[450px] xl:w-[500px] bg-white/10 backdrop-blur-xl border-b lg:border-b-0 lg:border-r border-white/20 p-8 sm:p-12 flex flex-col min-h-screen lg:h-screen lg:overflow-y-auto custom-scrollbar shadow-[0_10px_30px_rgba(0,0,0,0.5)] lg:shadow-[10px_0_30px_rgba(0,0,0,0.5)]">

      <!-- Brand Header -->
      <a href="/" style="font-family: 'Space Grotesk', sans-serif; letter-spacing: -0.3px;"
        class="flex items-center text-white font-bold text-2xl tracking-tight mb-12 hover:opacity-80 transition">
        <span
          class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-[#2BD5BB] text-gray-900 mr-3 shadow-lg">KP</span>
        Kos Pojok 12A
      </a>

      <div class="flex-1 flex flex-col justify-center">
        <!-- h1 "Selamat Datang" -->
        <h1 class="text-5xl font-bold text-white mb-7" style="font-family: 'Playfair Display', serif;">
          <em style="font-style: italic; color: #2BD5BB;">Selamat</em> Datang
        </h1>
        <p class="text-gray-300 text-sm mb-8">Gunakan akun Anda untuk mengelola pembayaran & keluhan dengan mudah.</p>

        @if(session('status'))
          <div
            class="mb-6 rounded-lg border border-green-400/50 bg-green-500/20 text-green-100 px-4 py-3 text-sm font-medium shadow-sm backdrop-blur-md">
            <div class="flex items-start gap-3">
              <svg class="w-5 h-5 flex-shrink-0 mt-0.5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                  clip-rule="evenodd" />
              </svg>
              <span>{{ session('status') }}</span>
            </div>
          </div>
        @endif

        @if($errors->any())
          <div
            class="mb-6 rounded-lg border border-red-500/50 bg-red-500/20 text-red-100 px-4 py-3 shadow-lg backdrop-blur-md animate-shake">
            <div class="flex items-start gap-3">
              <svg class="w-6 h-6 flex-shrink-0 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                  clip-rule="evenodd" />
              </svg>
              <div class="flex-1">
                <p class="font-bold text-base mb-2 text-white">Terjadi Kesalahan!</p>
                <ul class="space-y-1.5 text-sm font-medium">
                  @foreach($errors->all() as $error)
                    <li class="flex items-start gap-2">
                      <span class="text-red-400 font-bold mt-0.5">•</span>
                      <span>{{ $error }}</span>
                    </li>
                  @endforeach
                </ul>
              </div>
            </div>
          </div>
        @endif

        <!-- Alert untuk validasi JavaScript (client-side) -->
        <div id="jsErrorAlert"
          class="mb-6 rounded-lg border border-red-500/50 bg-red-500/20 text-red-100 px-4 py-3 shadow-lg backdrop-blur-md animate-shake hidden">
          <div class="flex items-start gap-3">
            <svg class="w-6 h-6 flex-shrink-0 text-red-400" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd"
                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                clip-rule="evenodd" />
            </svg>
            <div class="flex-1">
              <p class="font-bold text-base mb-2 text-white">Terjadi Kesalahan!</p>
              <ul id="jsErrorList" class="space-y-1.5 text-sm font-medium"></ul>
            </div>
          </div>
        </div>

        <form method="POST" action="{{ route('login') }}" id="loginForm" class="space-y-5">
          @csrf

          <div>
            <label for="email" class="block text-sm font-medium text-gray-200"
              style="font-family: 'Space Grotesk', sans-serif; letter-spacing: 1px; text-transform: uppercase; font-size: 11px;">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" autofocus autocomplete="email"
              class="mt-1 block w-full rounded-xl bg-white/5 border border-white/20 text-white placeholder-gray-400 shadow-sm focus:bg-white/10 focus:border-[#2BD5BB] focus:ring-[#2BD5BB] transition duration-200 @error('email') border-red-500 bg-red-500/10 @enderror">
            @error('email')
              <p class="mt-1.5 text-sm text-red-400 font-medium">{{ $message }}</p>
            @enderror
          </div>

          <div x-data="{show:false}">
            <label for="password" class="block text-sm font-medium text-gray-200"
              style="font-family: 'Space Grotesk', sans-serif; letter-spacing: 1px; text-transform: uppercase; font-size: 11px;">Password</label>
            <div class="mt-1 relative">
              <input :type="show ? 'text' : 'password'" type="password" id="password" name="password" autocomplete="current-password"
                class="block w-full rounded-xl bg-white/5 border border-white/20 text-white placeholder-gray-400 shadow-sm focus:bg-white/10 focus:border-[#2BD5BB] focus:ring-[#2BD5BB] pr-10 transition duration-200 @error('password') border-red-500 bg-red-500/10 @enderror">
              <button type="button" @click="show=!show"
                class="absolute inset-y-0 right-0 px-3 text-gray-400 hover:text-white transition"
                aria-label="Toggle password">
                <svg x-show="!show" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                <svg x-show="show" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a10.05 10.05 0 012.042-3.368M6.177 6.177A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a10.052 10.052 0 01-4.043 5.073M15 12a3 3 0 00-3-3M3 3l18 18" />
                </svg>
              </button>
            </div>
            @error('password')
              <p class="mt-1.5 text-sm text-red-400 font-medium">{{ $message }}</p>
            @enderror
          </div>

          <div class="pt-2">
            <button type="submit"
              class="w-full inline-flex justify-center items-center rounded-xl bg-[#2BD5BB] text-gray-900 px-4 py-3 font-bold hover:bg-[#23bda6] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-900 focus:ring-[#2BD5BB] transition-all transform hover:scale-[1.02] shadow-lg">
              Masuk ke Dashboard
            </button>
          </div>
        </form>

        <p class="mt-8 text-center text-sm text-gray-400">
          Belum punya akun?
          <a href="{{ route('register') }}"
            class="font-semibold text-[#2BD5BB] hover:text-[#23bda6] hover:underline transition">Daftar sekarang</a>
        </p>
      </div>

      <footer class="mt-8 text-[10px] font-black text-white/40 tracking-[0.2em] uppercase text-center">
        &copy; {{ date('Y') }} Kos Pojok 12A. All Rights Reserved
      </footer>
    </div>

    <!-- Right Side: Dormitory Information System / Landing Area -->
    <div
      class="flex flex-1 p-8 lg:p-12 xl:p-24 flex-col justify-center relative min-h-screen lg:h-screen lg:overflow-y-auto custom-scrollbar"
      x-data="{ showRooms: false }">
      <!-- Decorational glowing orbs -->
      <div
        class="absolute top-1/4 left-1/4 w-64 lg:w-96 h-64 lg:h-96 bg-[#2BD5BB]/20 rounded-full blur-[80px] lg:blur-[100px] pointer-events-none">
      </div>
      <div
        class="absolute bottom-1/4 right-1/4 w-64 lg:w-96 h-64 lg:h-96 bg-indigo-500/20 rounded-full blur-[80px] lg:blur-[100px] pointer-events-none">
      </div>

      <div class="max-w-4xl relative z-10">
        <div
          class="inline-flex items-center px-4 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white text-sm font-semibold mb-8 shadow-sm">
          <span class="flex h-2 w-2 rounded-full bg-[#2BD5BB] mr-2 animate-pulse"></span>
          Sistem Informasi Kos Modern
        </div>

        <!-- h2 kanan "Pilihan Tempat Tinggal..." -->
        <h2 class="text-4xl lg:text-5xl xl:text-7xl font-extrabold text-white leading-tight mb-6 drop-shadow-xl"
          style="font-family: 'Playfair Display', serif; font-weight: 700;">
          Pilihan Tempat Tinggal<br class="hidden sm:block">Terbaik Untuk<br class="hidden sm:block">
          <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#2BD5BB] to-indigo-400"
            style="font-style: italic;">
            Kenyamanan Anda
          </span>
        </h2>

        <div x-show="!showRooms" x-transition:enter="transition ease-out duration-300"
          x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
          <p class="text-lg xl:text-xl text-gray-200 mb-8 max-w-2xl leading-relaxed drop-shadow-md">
            Temukan dan pilih kamar yang sesuai dengan kebutuhan Anda. Kami menyediakan fasilitas lengkap dengan harga
            terbaik di Kos Pojok 12A.
          </p>
          <button @click="showRooms = true"
            class="inline-flex items-center rounded-xl bg-[#2BD5BB] text-gray-900 px-6 py-3 font-bold hover:bg-[#23bda6] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-900 focus:ring-[#2BD5BB] transition-all shadow-lg">
            Lihat Kamar Tersedia
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd"
                d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                clip-rule="evenodd" />
            </svg>
          </button>
        </div>

        <div x-show="showRooms" style="display: none;" x-transition:enter="transition ease-out duration-300 delay-100"
          x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
          <button @click="showRooms = false"
            class="mb-6 inline-flex items-center text-gray-300 hover:text-white transition font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd"
                d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z"
                clip-rule="evenodd" />
            </svg>
            Kembali
          </button>

          @if(isset($availableRooms) && $availableRooms->count() > 0)
            <div
              class="grid grid-cols-1 sm:grid-cols-2 gap-5 max-w-3xl max-h-[500px] lg:max-h-[450px] overflow-y-auto pr-2 custom-scrollbar">
              @foreach($availableRooms as $room)
                @php
                  $photos = (is_array($room->photos) && count($room->photos) > 0)
                    ? array_map(function ($p) {
                      return asset('storage/' . $p);
                    }, $room->photos)
                    : ['/images/dorm-bg.jpg'];
                @endphp
                <div x-data="{ activeIndex: 0, photos: {{ json_encode($photos) }} }"
                  class="group relative bg-white/5 backdrop-blur-md border border-white/10 rounded-3xl overflow-hidden flex flex-col h-[380px] transition-all duration-500 hover:shadow-[0_20px_50px_rgba(0,0,0,0.3)]">
                  
                  <!-- Photo Area (Center Stage) -->
                  <div class="relative flex-1 bg-gray-800 overflow-hidden">
                    <div class="absolute inset-0 bg-cover bg-center"
                      :style="`background-image: url('${photos[activeIndex]}')`" style="transition: background-image 0.5s ease-in-out;"></div>
                    
                    <!-- Gradient Overlay for readability -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>

                    <!-- Room Number & Status (Top Overlay) -->
                    <div class="absolute top-4 left-4 right-4 flex justify-between items-start z-20">
                      <div class="bg-black/40 backdrop-blur-md border border-white/20 px-4 py-1.5 rounded-xl shadow-lg min-w-[120px] flex justify-center items-center">
                        <span class="text-xs font-black text-white tracking-widest uppercase">Kamar {{ $room->room_number }}</span>
                      </div>
                      <span class="px-3 py-1 bg-[#2BD5BB]/20 text-[#2BD5BB] text-[10px] font-black uppercase tracking-widest rounded-full border border-[#2BD5BB]/30 backdrop-blur-md">Tersedia</span>
                    </div>

                    <!-- Photo Navigation Arrows (Visible on Mobile, Hover on Desktop) -->
                    <template x-if="photos.length > 1">
                      <div class="absolute inset-y-0 left-0 right-0 flex items-center justify-between px-3 lg:opacity-0 lg:group-hover:opacity-100 transition-opacity duration-300 z-30">
                        <button @click.prevent="activeIndex = activeIndex === 0 ? photos.length - 1 : activeIndex - 1"
                          class="w-10 h-10 flex items-center justify-center rounded-full bg-white/10 backdrop-blur-md text-white hover:bg-white/20 border border-white/20 transition transform active:scale-90">
                          <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                          </svg>
                        </button>
                        <button @click.prevent="activeIndex = activeIndex === photos.length - 1 ? 0 : activeIndex + 1"
                          class="w-10 h-10 flex items-center justify-center rounded-full bg-white/10 backdrop-blur-md text-white hover:bg-white/20 border border-white/20 transition transform active:scale-90">
                          <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                          </svg>
                        </button>
                      </div>
                    </template>

                    <!-- Info Overlay (Bottom) -->
                    <div class="absolute bottom-4 left-4 right-4 z-20">
                      <div class="flex items-end justify-between gap-4">
                        <div class="flex-1">
                          <p class="text-[10px] font-bold text-[#2BD5BB] uppercase tracking-[0.2em] mb-1">Mulai Dari</p>
                          <p class="text-2xl font-black text-white leading-none">
                            Rp {{ number_format($room->price, 0, ',', '.') }}<span class="text-sm text-gray-400 font-medium ml-1">/bln</span>
                          </p>
                        </div>
                        
                        <!-- Mini Dot Pagination -->
                        <template x-if="photos.length > 1">
                          <div class="flex gap-1.5 pb-2">
                            <template x-for="(photo, index) in photos" :key="index">
                              <div class="h-1.5 rounded-full transition-all duration-300"
                                :class="activeIndex === index ? 'w-4 bg-[#2BD5BB]' : 'w-1.5 bg-white/30'"></div>
                            </template>
                          </div>
                        </template>
                      </div>
                    </div>
                  </div>

                  <!-- Facilities Area (Bottom Bar) -->
                  <div class="bg-white/5 backdrop-blur-sm px-5 py-4 border-t border-white/10">
                    @if(is_array($room->facilities) && count($room->facilities) > 0)
                      <div class="flex flex-wrap gap-2">
                        @foreach(array_slice($room->facilities, 0, 3) as $facility)
                          <span class="inline-flex items-center text-[10px] font-bold text-gray-300 bg-white/5 border border-white/10 px-2.5 py-1 rounded-lg uppercase tracking-wider">
                            {{ $facility }}
                          </span>
                        @endforeach
                        @if(count($room->facilities) > 3)
                          <span class="inline-flex items-center text-[10px] font-bold text-[#2BD5BB] bg-[#2BD5BB]/5 border border-[#2BD5BB]/10 px-2 py-1 rounded-lg">
                            +{{ count($room->facilities) - 3 }}
                          </span>
                        @endif
                      </div>
                    @else
                      <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest italic">Fasilitas Standar</p>
                    @endif
                  </div>
                </div>
              @endforeach
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
          @else
            <div class="bg-black/30 backdrop-blur-md border border-white/10 p-6 rounded-2xl max-w-3xl text-center">
              <p class="text-gray-300">Saat ini tidak ada kamar yang tersedia.</p>
            </div>
          @endif
        </div>
      </div>
    </div>

  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const form = document.getElementById('loginForm');
      const emailInput = document.getElementById('email');
      const passwordInput = document.getElementById('password');
      const jsErrorAlert = document.getElementById('jsErrorAlert');
      const jsErrorList = document.getElementById('jsErrorList');

      function validateEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
      }

      function showJsError(errors) {
        jsErrorList.innerHTML = '';
        errors.forEach(error => {
          const li = document.createElement('li');
          li.className = 'flex items-start gap-2';
          li.innerHTML = '<span class="text-red-400 font-bold mt-0.5">•</span><span>' + error + '</span>';
          jsErrorList.appendChild(li);
        });

        jsErrorAlert.classList.remove('hidden');
        jsErrorAlert.classList.remove('animate-shake');
        void jsErrorAlert.offsetWidth; // Trigger reflow
        jsErrorAlert.classList.add('animate-shake');

        jsErrorAlert.scrollIntoView({ behavior: 'smooth', block: 'center' });
      }

      function hideJsError() {
        jsErrorAlert.classList.add('hidden');
      }

      function removeInputError(input) {
        input.classList.remove('border-red-500', 'bg-red-500/10');
        input.classList.add('border-white/20', 'bg-white/5');
      }

      function addInputError(input) {
        input.classList.remove('border-white/20', 'bg-white/5');
        input.classList.add('border-red-500', 'bg-red-500/10');
        input.classList.remove('animate-shake');
        void input.offsetWidth;
        input.classList.add('animate-shake');
      }

      emailInput.addEventListener('input', function () {
        hideJsError();
        removeInputError(emailInput);
      });

      passwordInput.addEventListener('input', function () {
        hideJsError();
        removeInputError(passwordInput);
      });

      form.addEventListener('submit', function (e) {
        const email = emailInput.value.trim();
        const password = passwordInput.value.trim();
        const errors = [];

        removeInputError(emailInput);
        removeInputError(passwordInput);
        hideJsError();

        if (email === '') {
          errors.push('Email tidak boleh kosong!');
          addInputError(emailInput);
        } else if (!validateEmail(email)) {
          errors.push('Format email tidak valid! Contoh: user@example.com');
          addInputError(emailInput);
        }

        if (password === '') {
          errors.push('Password tidak boleh kosong!');
          addInputError(passwordInput);
        }

        if (errors.length > 0) {
          e.preventDefault();
          showJsError(errors);
          return false;
        }
      });
    });
  </script>
</body>

</html>