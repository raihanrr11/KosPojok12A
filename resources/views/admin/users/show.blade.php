@extends('admin.layout')

@section('content')
<div class="space-y-6">
    <!-- Header Page -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.users') }}" class="p-2 bg-white rounded-xl shadow-sm text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Detail Penghuni</h1>
                <p class="text-sm text-gray-500">Melihat detail informasi, pembayaran, dan keluhan</p>
            </div>
        </div>
        
        @if(!$user->trashed())
            <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 transform hover:scale-105 transition-all duration-300">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit Penghuni
            </a>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Card -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-2xl shadow-md overflow-hidden relative">
                <!-- Top Gradient Banner -->
                <div class="h-32 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 absolute w-full top-0 left-0"></div>
                
                <div class="px-6 pt-16 pb-6 relative z-10 text-center">
                    <div class="relative inline-block mb-4">
                        @if($user->photo)
                            <img src="{{ Storage::url($user->photo) }}" alt="{{ $user->name }}" class="w-24 h-24 rounded-2xl object-cover shadow-xl ring-4 ring-white mx-auto">
                        @else
                            <div class="w-24 h-24 rounded-2xl bg-gradient-to-br from-indigo-100 to-purple-200 flex items-center justify-center shadow-xl ring-4 ring-white mx-auto">
                                <span class="text-4xl font-bold text-indigo-700">{{ substr($user->name, 0, 1) }}</span>
                            </div>
                        @endif
                        
                        @if($user->trashed())
                            <span class="absolute -bottom-2 -right-2 bg-red-500 text-white p-1.5 rounded-full shadow-lg ring-2 ring-white" title="Pindah / Dihapus">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        @else
                            <span class="absolute -bottom-2 -right-2 bg-green-500 text-white p-1.5 rounded-full shadow-lg ring-2 ring-white" title="Penghuni Aktif">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        @endif
                    </div>
                    
                    <h2 class="text-2xl font-bold text-gray-900 mb-1">{{ $user->name }}</h2>
                    <p class="text-indigo-600 font-bold mb-4">Kamar {{ $user->room_number }}</p>
                    
                    @if($user->trashed())
                        <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-red-50 text-red-700 border border-red-100">
                            Pindah / Dihapus pada {{ $user->deleted_at->format('d M Y') }}
                        </div>
                    @endif
                </div>

                <div class="border-t border-gray-100 px-6 py-4 bg-gray-50/50">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500">Harga Sewa</span>
                        <span class="font-bold text-gray-900">Rp {{ number_format($user->monthly_rent, 0, ',', '.') }}<span class="text-gray-400 font-normal">/bln</span></span>
                    </div>
                </div>
            </div>

            <!-- Kontak Info -->
            <div class="bg-white rounded-2xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                    Informasi Kontak
                </h3>
                <ul class="space-y-4">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <div>
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-0.5">Email</p>
                            <p class="text-sm font-medium text-gray-900">{{ $user->email }}</p>
                        </div>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        <div>
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-0.5">No. Telepon</p>
                            <p class="text-sm font-medium text-gray-900">{{ $user->phone ?? '-' }}</p>
                        </div>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <div>
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-0.5">Alamat Asal</p>
                            <p class="text-sm font-medium text-gray-900">{{ $user->address ?? '-' }}</p>
                        </div>
                    </li>
                    @if($user->emergency_contact)
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-red-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <div>
                            <p class="text-xs font-bold text-red-500 uppercase tracking-wider mb-0.5">Kontak Darurat</p>
                            <p class="text-sm font-medium text-gray-900">{{ $user->emergency_contact }}</p>
                        </div>
                    </li>
                    @endif
                </ul>
            </div>
        </div>

        <!-- Right Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Riwayat Pembayaran -->
            <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900">Pembayaran Terakhir</h3>
                    @if(Schema::hasTable('payments'))
                        <a href="{{ route('admin.payments') }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-800">Lihat Semua &rarr;</a>
                    @endif
                </div>
                <div class="divide-y divide-gray-50">
                    @forelse($payments as $payment)
                        <div class="p-4 flex items-center justify-between hover:bg-gray-50 transition-colors">
                            <div>
                                <p class="text-sm font-bold text-gray-900">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-500">{{ $payment->created_at->format('d F Y, H:i') }}</p>
                            </div>
                            <div>
                                @if($payment->status === 'verified')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800">Terverifikasi</span>
                                @elseif($payment->status === 'rejected')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-800">Ditolak</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800">Pending</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-gray-500 text-sm">
                            Belum ada riwayat pembayaran.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Riwayat Keluhan -->
            <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900">Keluhan Terakhir</h3>
                    @if(Schema::hasTable('complaints'))
                        <a href="{{ route('admin.complaints') }}" class="text-sm font-bold text-pink-600 hover:text-pink-800">Lihat Semua &rarr;</a>
                    @endif
                </div>
                <div class="divide-y divide-gray-50">
                    @forelse($complaints as $complaint)
                        <div class="p-4 flex items-center justify-between hover:bg-gray-50 transition-colors">
                            <div>
                                <p class="text-sm font-bold text-gray-900">{{ $complaint->subject }}</p>
                                <p class="text-xs text-gray-500">{{ $complaint->created_at->format('d F Y, H:i') }}</p>
                            </div>
                            <div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-800">
                                    {{ $complaint->status_label }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-gray-500 text-sm">
                            Belum ada riwayat keluhan.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
