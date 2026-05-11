@extends('admin.layout')

@section('content')
<div class="max-w-5xl mx-auto space-y-6" x-data="{ statusModal: false, newStatus: '{{ $complaint->status }}', newStatusLabel: '' }">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.complaints') }}" class="p-2 bg-white rounded-xl shadow-sm border border-gray-100 text-gray-400 hover:text-indigo-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Detail Keluhan</h2>
                <p class="text-sm text-gray-500 font-medium">ID Keluhan: #{{ $complaint->id }} • Diajukan {{ $complaint->created_at->diffForHumans() }}</p>
            </div>
        </div>
        <div class="flex items-center space-x-3">
             @if($complaint->status === 'resolved')
                <span class="px-4 py-2 rounded-xl text-xs font-black bg-green-100 text-green-700 uppercase tracking-widest border border-green-200">✓ Selesai</span>
            @elseif($complaint->status === 'in_progress')
                <span class="px-4 py-2 rounded-xl text-xs font-black bg-blue-100 text-blue-700 uppercase tracking-widest border border-blue-200 animate-pulse">⟳ Diproses</span>
            @else
                <span class="px-4 py-2 rounded-xl text-xs font-black bg-red-100 text-red-700 uppercase tracking-widest border border-red-200">⚠ Kendala</span>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Complaint Details Card -->
            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="p-8">
                    <div class="flex items-center space-x-3 mb-6">
                        @if($complaint->priority === 'high')
                            <span class="px-3 py-1 rounded-lg text-[10px] font-black bg-red-50 text-red-600 border border-red-100 uppercase tracking-tighter">🔥 Prioritas Tinggi</span>
                        @elseif($complaint->priority === 'medium')
                            <span class="px-3 py-1 rounded-lg text-[10px] font-black bg-yellow-50 text-yellow-700 border border-yellow-100 uppercase tracking-tighter">⚡ Prioritas Sedang</span>
                        @else
                            <span class="px-3 py-1 rounded-lg text-[10px] font-black bg-gray-50 text-gray-500 border border-gray-100 uppercase tracking-tighter">☁ Prioritas Rendah</span>
                        @endif
                    </div>
                    <h1 class="text-3xl font-black text-gray-900 mb-6 leading-tight">{{ $complaint->subject }}</h1>
                    <div class="prose prose-indigo max-w-none text-gray-600 font-medium leading-relaxed">
                        {{ $complaint->description }}
                    </div>
                </div>
                @if($complaint->photo)
                <div class="px-8 pb-8">
                    <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Lampiran Foto</p>
                    <div class="relative group max-w-md">
                        <img src="{{ Storage::url($complaint->photo) }}" class="rounded-2xl border-4 border-gray-50 shadow-lg">
                        <a href="{{ Storage::url($complaint->photo) }}" target="_blank" class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center rounded-2xl backdrop-blur-[2px]">
                            <span class="bg-white px-4 py-2 rounded-xl font-bold text-gray-900 text-sm">Lihat Detail</span>
                        </a>
                    </div>
                </div>
                @endif
            </div>

            <!-- Admin Response Form -->
            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="bg-gray-50/50 px-8 py-5 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                        Respon & Update Admin
                    </h3>
                </div>
                <div class="p-8">
                    <form id="complaint-form" action="{{ route('admin.complaints.update', $complaint) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <!-- Status Selector -->
                        <div class="space-y-3">
                            <label class="text-sm font-black text-gray-400 uppercase tracking-widest ml-1">Update Status Keluhan</label>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                @foreach(['open' => 'Kendala', 'in_progress' => 'Proses', 'resolved' => 'Selesai', 'closed' => 'Tutup'] as $val => $label)
                                    <label class="cursor-pointer group">
                                        <input type="radio" name="status" value="{{ $val }}" class="hidden" 
                                            {{ $complaint->status === $val ? 'checked' : '' }}
                                            @click="newStatus = '{{ $val }}'; newStatusLabel = '{{ $label }}'">
                                        <div :class="newStatus === '{{ $val }}' ? 'bg-indigo-600 text-white shadow-indigo-200 border-indigo-600' : 'bg-white text-gray-600 border-gray-100 hover:border-indigo-300'"
                                            class="px-4 py-3 rounded-2xl border-2 text-center transition-all duration-300 shadow-sm transform group-hover:scale-[1.02]">
                                            <span class="text-sm font-black">{{ $label }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Admin Response -->
                        <div class="space-y-3">
                            <label for="admin_response" class="text-sm font-black text-gray-400 uppercase tracking-widest ml-1">Catatan Admin</label>
                            <textarea name="admin_response" id="admin_response" rows="6" 
                                placeholder="Tuliskan tindakan yang diambil atau respon untuk penghuni..."
                                class="block w-full rounded-2xl border-gray-100 bg-gray-50/50 px-5 py-4 text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 transition-all resize-none shadow-inner">{{ old('admin_response', $complaint->admin_response) }}</textarea>
                            <p class="text-[11px] text-gray-400 italic ml-1">Respon ini dapat dibaca oleh penghuni secara real-time.</p>
                        </div>

                        <div class="pt-4">
                            <button type="button" @click="statusModal = true"
                                class="w-full inline-flex items-center justify-center px-8 py-4 rounded-2xl text-sm font-black text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 shadow-lg shadow-indigo-500/30 transform hover:scale-[1.02] transition-all">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                Update Keluhan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="lg:col-span-1 space-y-6">
            <!-- User Info Card -->
            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="p-6">
                    <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-6">Informasi Penghuni</h3>
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="h-16 w-16 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-2xl font-black shadow-lg ring-4 ring-indigo-50">
                            {{ substr($complaint->user->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-lg font-black text-gray-900 leading-none mb-1">{{ $complaint->user->name }}</p>
                            <p class="text-sm font-bold text-indigo-600">Kamar {{ $complaint->user->room_number ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="space-y-4 pt-4 border-t border-gray-50">
                        <div class="flex items-center text-sm">
                            <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span class="text-gray-600 font-medium">{{ $complaint->user->email }}</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span class="text-gray-600 font-medium">Terdaftar {{ $complaint->user->created_at->format('M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Guidelines Card -->
            <div class="bg-gradient-to-br from-indigo-600 to-purple-700 rounded-3xl shadow-xl p-6 text-white">
                <h3 class="text-sm font-black uppercase tracking-widest mb-4 opacity-80">Panduan Admin</h3>
                <ul class="space-y-4">
                    <li class="flex items-start">
                        <div class="h-5 w-5 rounded-full bg-white/20 flex items-center justify-center text-[10px] font-black mr-3 mt-0.5">1</div>
                        <p class="text-xs font-bold leading-relaxed">Berikan respon yang sopan dan jelas agar penghuni merasa didengar.</p>
                    </li>
                    <li class="flex items-start">
                        <div class="h-5 w-5 rounded-full bg-white/20 flex items-center justify-center text-[10px] font-black mr-3 mt-0.5">2</div>
                        <p class="text-xs font-bold leading-relaxed">Update status secara berkala agar penghuni tahu progres perbaikan.</p>
                    </li>
                    <li class="flex items-start">
                        <div class="h-5 w-5 rounded-full bg-white/20 flex items-center justify-center text-[10px] font-black mr-3 mt-0.5">3</div>
                        <p class="text-xs font-bold leading-relaxed">Lampirkan catatan jika ada kendala dalam proses penanganan.</p>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{-- CONFIRMATION MODAL --}}
    <template x-teleport="body">
        <div x-show="statusModal" x-cloak class="fixed inset-0 z-[9999] flex items-center justify-center p-4"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" @click="statusModal = false"></div>
        <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-sm overflow-hidden"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0">
            <div class="bg-gradient-to-br from-indigo-600 to-purple-700 px-6 pt-8 pb-6 text-center">
                <div class="mx-auto w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mb-4 ring-4 ring-white/30">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-black text-white">Simpan Perubahan?</h3>
                <p class="text-indigo-200 text-sm mt-1">Status keluhan akan diperbarui</p>
            </div>
            <div class="p-6">
                <div class="bg-indigo-50 border border-indigo-100 rounded-2xl p-4 mb-6">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500 font-medium">Status Baru</span>
                        <span class="font-black text-indigo-700 uppercase" x-text="newStatusLabel || '{{ $complaint->status }}'"></span>
                    </div>
                </div>
                <div class="flex gap-3">
                    <button type="button" @click="statusModal = false" class="flex-1 px-4 py-3 border border-gray-200 rounded-xl text-sm font-bold text-gray-600 bg-white hover:bg-gray-50 transition">Batal</button>
                    <button type="button" @click="document.getElementById('complaint-form').submit()" 
                        class="flex-1 px-4 py-3 rounded-xl text-sm font-black text-white bg-gradient-to-r from-indigo-600 to-purple-700 shadow-lg shadow-indigo-500/30 transition transform hover:scale-[1.02]">Ya, Simpan</button>
                </div>
            </div>
        </div>
    </div>
</template>
</div>
@endsection