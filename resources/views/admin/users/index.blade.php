@extends('admin.layout')

@section('content')
    <div class="space-y-6" x-data="{ deleteModal: false, deleteTarget: { name: '', formId: '' } }">
        <!-- Header dengan Gradient Background -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-indigo-600 to-purple-600 p-8 shadow-xl">
            <div class="relative z-10 sm:flex sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white">Manajemen Penghuni</h1>
                    <p class="mt-2 text-indigo-100">Kelola semua data penghuni kos dengan mudah</p>
                </div>
                <div class="mt-4 sm:mt-0">
                    <a href="{{ route('admin.users.create') }}"
                        class="inline-flex items-center px-6 py-3 border border-transparent rounded-xl shadow-lg text-sm font-bold text-indigo-600 bg-white hover:bg-indigo-50 transform hover:scale-105 transition-all duration-300">
                        <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Tambah Penghuni
                    </a>
                </div>
            </div>
            <div class="absolute top-0 right-0 -mt-4 -mr-4 h-32 w-32 rounded-full bg-white opacity-10"></div>
            <div class="absolute bottom-0 left-0 -mb-8 -ml-8 h-40 w-40 rounded-full bg-white opacity-5"></div>
        </div>

        <!-- Users List dengan Modern Cards -->
        <div class="grid grid-cols-1 gap-6">
            @forelse($users as $user)
                <div
                    class="group bg-white rounded-xl shadow-md hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-start justify-between">
                            <!-- User Info -->
                            <div class="flex items-start space-x-4 flex-1">
                                <!-- Avatar dengan Hover Effect -->
                                <div class="flex-shrink-0">
                                    @if($user->photo)
                                        <img src="{{ Storage::url($user->photo) }}" alt="{{ $user->name }}"
                                            class="h-16 w-16 rounded-xl object-cover shadow-md group-hover:shadow-xl group-hover:scale-110 transition-all duration-300 ring-4 ring-white">
                                    @else
                                        <div
                                            class="h-16 w-16 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-md group-hover:shadow-xl group-hover:scale-110 transition-all duration-300 ring-4 ring-white">
                                            <span class="text-2xl font-bold text-white">{{ $user->initials }}</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- User Details -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center space-x-3 mb-2">
                                        <h3
                                            class="text-xl font-bold text-gray-900 group-hover:text-indigo-600 transition-colors duration-200">
                                            {{ $user->name }}
                                        </h3>
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 shadow-sm">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                                </path>
                                            </svg>
                                            Kamar {{ $user->room_number ?? 'No Room' }}
                                        </span>
                                    </div>

                                    <!-- Contact Info dengan Icons -->
                                    <div class="space-y-2">
                                        <div class="flex items-center text-sm text-gray-600">
                                            <svg class="w-4 h-4 mr-2 text-indigo-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z">
                                                </path>
                                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                            </svg>
                                            <span class="font-medium">{{ $user->email }}</span>
                                        </div>

                                        <div class="flex items-center text-sm text-gray-600">
                                            <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z">
                                                </path>
                                            </svg>
                                            <span class="font-medium">{{ $user->phone ?? 'Tidak ada nomor' }}</span>
                                        </div>

                                        <div class="flex items-center text-sm text-gray-600">
                                            <svg class="w-4 h-4 mr-2 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z">
                                                </path>
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="font-bold text-gray-900">Rp
                                                {{ number_format($user->monthly_rent ?? 0, 0, ',', '.') }}</span>
                                            <span class="text-gray-500 ml-1">/ bulan</span>
                                        </div>

                                        @if($user->date_of_birth)
                                            <div class="flex items-center text-sm text-gray-600">
                                                <svg class="w-4 h-4 mr-2 text-pink-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                <span>{{ $user->date_of_birth->format('d F Y') }}</span>
                                                <span class="ml-1 text-gray-500">({{ $user->date_of_birth->age }} tahun)</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Additional Info - Collapsible -->
                                    @if($user->address || $user->emergency_contact)
                                        <div class="mt-4 pt-4 border-t border-gray-100">
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                                @if($user->address)
                                                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-3 rounded-lg">
                                                        <p class="text-xs font-bold text-indigo-600 mb-1">Alamat Asal</p>
                                                        <p class="text-sm text-gray-700">{{ $user->address }}</p>
                                                    </div>
                                                @endif
                                                @if($user->emergency_contact)
                                                    <div class="bg-gradient-to-br from-red-50 to-pink-50 p-3 rounded-lg">
                                                        <p class="text-xs font-bold text-red-600 mb-1">Kontak Darurat</p>
                                                        <p class="text-sm text-gray-700">{{ $user->emergency_contact }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex flex-col space-y-2 ml-4">
                                <a href="{{ route('admin.users.edit', $user) }}"
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 transform hover:scale-105 transition-all duration-300">
                                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit
                                </a>
                                <form id="delete-user-{{ $user->id }}" method="POST"
                                    action="{{ route('admin.users.destroy', $user) }}" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button type="button"
                                    @click="deleteTarget = { name: '{{ addslashes($user->name) }}', formId: 'delete-user-{{ $user->id }}' }; deleteModal = true"
                                    class="w-full inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-gradient-to-r from-red-600 to-pink-600 hover:from-red-700 hover:to-pink-700 transform hover:scale-105 transition-all duration-300">
                                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Accent Bar -->
                    <div
                        class="h-1 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500">
                    </div>
                </div>
            @empty
                <!-- Empty State -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="px-4 py-16 text-center">
                        <div
                            class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-br from-indigo-100 to-purple-100 mb-4">
                            <svg class="w-10 h-10 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Penghuni</h3>
                        <p class="text-gray-600">Mulai tambahkan penghuni pertama Anda</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if(isset($users) && $users->hasPages())
            <div class="bg-white rounded-xl shadow-md px-4 py-3">
                {{ $users->links() }}
            </div>
        @endif

        {{-- Delete User Confirmation Modal --}}
        <template x-teleport="body">
            <div x-show="deleteModal" x-cloak class="fixed inset-0 z-[9999] flex items-center justify-center p-4"
                x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" @click="deleteModal = false"></div>
                <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-sm overflow-hidden"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0">
                    <div class="bg-gradient-to-br from-red-500 to-pink-600 px-6 pt-8 pb-6 text-center">
                        <div
                            class="mx-auto w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mb-4 ring-4 ring-white/30">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-black text-white">Hapus Penghuni?</h3>
                        <p class="text-red-100 text-sm mt-1">Tindakan ini tidak dapat dibatalkan</p>
                    </div>
                    <div class="p-6">
                        <p class="text-sm text-gray-600 text-center font-medium mb-2">Anda akan menghapus data penghuni:</p>
                        <p class="text-center font-black text-gray-900 text-lg mb-5" x-text="deleteTarget.name"></p>
                        <p class="text-xs text-gray-400 text-center mb-6">Seluruh data, riwayat pembayaran, dan keluhan
                            terkait akan terhapus permanen.</p>
                        <div class="flex gap-3">
                            <button type="button" @click="deleteModal = false"
                                class="flex-1 px-4 py-3 border border-gray-200 rounded-xl text-sm font-bold text-gray-600 bg-white hover:bg-gray-50 transition">
                                Batal
                            </button>
                            <button type="button" @click="document.getElementById(deleteTarget.formId).submit()"
                                class="flex-1 px-4 py-3 rounded-xl text-sm font-black text-white bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700 shadow-lg shadow-red-500/30 transition transform hover:scale-[1.02]">
                                Ya, Hapus
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
@endsection