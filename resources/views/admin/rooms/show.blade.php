@extends('admin.layout')

@section('content')
<div class="space-y-6" x-data="{ deleteModal: false }">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900">Detail Kamar {{ $room->room_number }}</h2>
        <div class="flex space-x-3">
            <a href="{{ route('admin.rooms.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                Kembali
            </a>
            <a href="{{ route('admin.rooms.edit', $room) }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white hover:from-indigo-700 hover:to-purple-700 transition-colors">
                Edit Kamar
            </a>
            <form id="delete-room-form" action="{{ route('admin.rooms.destroy', $room) }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>
            <button type="button" @click="deleteModal = true"
                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-500 to-pink-600 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white hover:from-red-600 hover:to-pink-700 transition-colors">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Hapus
            </button>
        </div>
    </div>

    <!-- Layout: Photos Left, Details Right -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Left Side: Photos Gallery -->
        <div class="space-y-6">
            <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                @php
                    $photoUrls = [];
                    if ($room->photos) {
                        foreach($room->photos as $p) {
                            $photoUrls[] = Storage::url($p);
                        }
                    }
                @endphp

                @if(count($photoUrls) > 0)
                    <!-- Alpine component for image gallery & swiper -->
                    <div x-data="{ 
                            currentIndex: 0, 
                            photos: {{ json_encode($photoUrls) }},
                            next() { this.currentIndex = this.currentIndex === this.photos.length - 1 ? 0 : this.currentIndex + 1; },
                            prev() { this.currentIndex = this.currentIndex === 0 ? this.photos.length - 1 : this.currentIndex - 1; }
                        }" class="p-6">
                        
                        <!-- Main Image with Arrows -->
                        <div class="relative aspect-[4/3] w-full rounded-xl overflow-hidden mb-4 bg-gray-100 shadow-inner group">
                            <img :src="photos[currentIndex]" class="w-full h-full object-contain transition-all duration-300">
                            
                            <!-- Swipe Arrows Overlay -->
                            <template x-if="photos.length > 1">
                                <div>
                                    <button @click="prev()" class="absolute left-3 top-1/2 -translate-y-1/2 bg-white/80 text-gray-800 hover:text-indigo-600 rounded-full p-2 hover:bg-white shadow-md transition-all focus:outline-none opacity-0 group-hover:opacity-100">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                        </svg>
                                    </button>
                                    <button @click="next()" class="absolute right-3 top-1/2 -translate-y-1/2 bg-white/80 text-gray-800 hover:text-indigo-600 rounded-full p-2 hover:bg-white shadow-md transition-all focus:outline-none opacity-0 group-hover:opacity-100">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                        
                        <!-- Thumbnails -->
                        <template x-if="photos.length > 1">
                            <div class="flex space-x-4 overflow-x-auto pb-2 scrollbar-thin scrollbar-thumb-indigo-200">
                                <template x-for="(photo, index) in photos" :key="index">
                                    <button @click="currentIndex = index" 
                                            class="flex-shrink-0 w-20 h-20 sm:w-24 sm:h-24 rounded-lg overflow-hidden border-2 focus:outline-none transition-colors duration-200"
                                            :class="currentIndex === index ? 'border-indigo-500 ring-2 ring-indigo-300' : 'border-transparent hover:border-gray-300'">
                                        <img :src="photo" class="w-full h-full object-cover">
                                    </button>
                                </template>
                            </div>
                        </template>
                    </div>
                @else
                    <div class="aspect-[4/3] w-full flex items-center justify-center bg-gray-100 text-gray-400 p-6">
                        <div class="text-center">
                            <svg class="mx-auto h-16 w-16 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2-2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="mt-2 text-sm font-medium">Tidak ada foto kamar.</p>
                        </div>
                    </div>
                @endif
            </div>
            

        </div>

        <!-- Right Side: Room Details -->
        <div class="space-y-6">
            
            <!-- Price and Status -->
            <div class="bg-white rounded-2xl shadow-md overflow-hidden relative">
                <div class="h-2 w-full bg-gradient-to-r from-indigo-500 to-purple-500"></div>
                <div class="p-6">
                    <div class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-1">Harga Sewa</div>
                    <div class="text-3xl font-black text-indigo-600 mb-4">
                        Rp {{ number_format($room->price, 0, ',', '.') }}<span class="text-sm text-gray-500 font-normal"> / bulan</span>
                    </div>

                    <div class="border-t border-gray-100 pt-4 mt-4">
                        <div class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-2">Status Kamar</div>
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold shadow-sm bg-{{ $room->status_color }}-100 text-{{ $room->status_color }}-800">
                            {{ $room->status_label }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="bg-white rounded-2xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">Deskripsi Kamar</h3>
                @if($room->description)
                    <p class="text-gray-700 whitespace-pre-line leading-relaxed">{{ $room->description }}</p>
                @else
                    <p class="text-gray-400 italic">Tidak ada deskripsi untuk kamar ini.</p>
                @endif
            </div>

            <!-- Facilities -->
            <div class="bg-white rounded-2xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                    </svg>
                    Fasilitas Kamar
                </h3>
                
                @if($room->facilities && count($room->facilities) > 0)
                    <ul class="space-y-3">
                        @foreach($room->facilities as $facility)
                            <li class="flex items-start">
                                <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700 font-medium">{{ $facility }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-400 italic">Belum ada fasilitas yang ditambahkan.</p>
                @endif
            </div>
            
        </div>
    </div>
    {{-- Delete Room Confirmation Modal --}}
    <template x-teleport="body">
        <div x-show="deleteModal" x-cloak
            class="fixed inset-0 z-[9999] flex items-center justify-center p-4"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" @click="deleteModal = false"></div>
        <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-sm overflow-hidden"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0">
            <div class="bg-gradient-to-br from-red-500 to-pink-600 px-6 pt-8 pb-6 text-center">
                <div class="mx-auto w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mb-4 ring-4 ring-white/30">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>
                <h3 class="text-xl font-black text-white">Hapus Kamar {{ $room->room_number }}?</h3>
                <p class="text-red-100 text-sm mt-1">Tindakan ini tidak dapat dibatalkan</p>
            </div>
            <div class="p-6">
                <p class="text-sm text-gray-600 text-center font-medium mb-6">
                    Semua foto dan data terkait kamar <strong>{{ $room->room_number }}</strong> akan terhapus secara permanen.
                </p>
                <div class="flex gap-3">
                    <button type="button" @click="deleteModal = false"
                        class="flex-1 px-4 py-3 border border-gray-200 rounded-xl text-sm font-bold text-gray-600 bg-white hover:bg-gray-50 transition">Batal</button>
                    <button type="button" @click="document.getElementById('delete-room-form').submit()"
                        class="flex-1 px-4 py-3 rounded-xl text-sm font-black text-white bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700 shadow-lg shadow-red-500/30 transition transform hover:scale-[1.02]">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </div>
</template>
</div>
@endsection
