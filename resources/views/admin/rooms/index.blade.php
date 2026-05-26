@extends('admin.layout')

@section('content')
    <div
        class="sticky top-0 z-20 bg-gray-50/80 backdrop-blur-md -mx-4 px-4 sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8 py-6 border-b border-gray-100 mb-6">
        <div class="space-y-6">
            <!-- Header -->
            <div
                class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 p-8 shadow-xl">
                <div class="relative z-10 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-white">Manajemen Kamar</h1>
                        <p class="mt-2 text-indigo-100">Kelola informasi, harga, dan ketersediaan kamar</p>
                    </div>
                    <div class="mt-4 sm:mt-0">
                        <a href="{{ route('admin.rooms.create') }}"
                            class="inline-flex items-center px-6 py-3 border border-transparent rounded-xl shadow-lg text-sm font-bold text-indigo-600 bg-white hover:bg-indigo-50 transform hover:scale-105 transition-all duration-300">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Tambah Kamar
                        </a>
                    </div>
                </div>
                <div class="absolute top-0 right-0 -mt-4 -mr-4 h-32 w-32 rounded-full bg-white opacity-10"></div>
                <div class="absolute bottom-0 left-0 -mb-8 -ml-8 h-40 w-40 rounded-full bg-white opacity-5"></div>
            </div>

            <!-- Rooms Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                @forelse($rooms as $room)
                    <a href="{{ route('admin.rooms.show', $room) }}"
                        class="group bg-white rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden flex flex-col h-full">

                        <!-- Top Section: Room Number & Status -->
                        <div class="p-3 border-b border-gray-100 flex items-center justify-between bg-gray-50 flex-none">
                            <h3 class="text-sm font-bold text-gray-900 group-hover:text-indigo-600 transition-colors">Kamar
                                {{ $room->room_number }}
                            </h3>
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-bold shadow-sm bg-{{ $room->status_color }}-100 text-{{ $room->status_color }}-800">
                                {{ $room->status_label }}
                            </span>
                        </div>

                        <!-- Bottom Section: Details & Photo -->
                        <!-- Room Image (3:4 aspect ratio, object-contain object-center to ensure it fits consistently) -->
                        <div
                            class="relative aspect-[3/4] w-full bg-gray-100 overflow-hidden flex-none border-b border-gray-100">
                            @if($room->photos && count($room->photos) > 0)
                                <img src="{{ Storage::url($room->photos[0]) }}" alt="Kamar {{ $room->room_number }}"
                                    class="w-full h-full object-contain object-center group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <svg class="w-10 h-10 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2-2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <div class="flex-1 flex flex-col p-3 justify-end">
                            <!-- Details -->
                            <div class="flex flex-col gap-1.5">
                                <span class="text-sm font-bold text-indigo-600">Rp
                                    {{ number_format($room->price, 0, ',', '.') }}<span
                                        class="text-[9px] text-gray-500 font-normal">/bln</span></span>

                                @if($room->facilities && count($room->facilities) > 0)
                                    <div class="flex flex-wrap gap-1.5 mt-auto">
                                        @foreach(array_slice($room->facilities, 0, 3) as $facility)
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-md text-[10px] font-medium bg-gray-100 text-gray-600">
                                                {{ $facility }}
                                            </span>
                                        @endforeach
                                        @if(count($room->facilities) > 3)
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-md text-[10px] font-medium bg-gray-100 text-gray-600">
                                                +{{ count($room->facilities) - 3 }}
                                            </span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Bottom Accent -->
                        <div
                            class="h-1 w-full bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left mt-auto">
                        </div>
                    </a>
                @empty
                    <div class="col-span-full">
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                            <div
                                class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-br from-indigo-50 to-purple-50 mb-4">
                                <svg class="w-10 h-10 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Kamar</h3>
                            <p class="text-gray-500 mb-6">Mulai tambahkan kamar untuk ditampilkan di sistem</p>
                            <a href="{{ route('admin.rooms.create') }}"
                                class="inline-flex items-center px-6 py-3 border border-transparent rounded-xl shadow-md text-sm font-bold text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 transition-all duration-300">
                                Tambah Kamar Pertama
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($rooms->hasPages())
                <div class="bg-white rounded-xl shadow-md px-4 py-3">
                    {{ $rooms->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection