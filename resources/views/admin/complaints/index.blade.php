@extends('admin.layout')

@section('content')
    <div class="space-y-6" x-data="{
                    statusModal: false,
                    deleteModal: false,
                    target: { id: '', name: '', status: '', statusLabel: '', formId: '', deleteFormId: '' },
                    openStatus(id, name, status, statusLabel) {
                        this.target = { id, name, status, statusLabel, formId: 'status-form-' + id, deleteFormId: 'delete-form-' + id };
                        this.statusModal = true;
                    },
                    openDelete(id, name) {
                        this.target.id = id; this.target.name = name;
                        this.target.deleteFormId = 'delete-form-' + id;
                        this.deleteModal = true;
                    }
                }">

        {{-- Header --}}
        <div
            class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-red-600 via-pink-600 to-purple-600 p-8 shadow-xl">
            <div class="relative z-10">
                <h1 class="text-3xl font-bold text-white">Manajemen Keluhan</h1>
                <p class="mt-2 text-red-100">Kelola dan tanggapi keluhan dari penghuni dengan cepat dan efisien</p>
            </div>
            <div class="absolute top-0 right-0 -mt-4 -mr-4 h-32 w-32 rounded-full bg-white opacity-10"></div>
            <div class="absolute bottom-0 left-0 -mb-8 -ml-8 h-40 w-40 rounded-full bg-white opacity-5"></div>
        </div>

        {{-- Date Filters --}}
        <div class="bg-white rounded-xl shadow-md p-4">
            <form action="{{ route('admin.complaints') }}" method="GET"
                class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Visibilitas</label>
                    <select name="visibility" class="w-full rounded-lg border-gray-200 text-sm focus:ring-red-500 focus:border-red-500">
                        <option value="">Semua</option>
                        <option value="1" {{ request('visibility') === '1' ? 'selected' : '' }}>Public</option>
                        <option value="0" {{ request('visibility') === '0' ? 'selected' : '' }}>Private</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Tanggal
                        Spesifik</label>
                    <input type="date" name="date" value="{{ request('date') }}"
                        class="w-full rounded-lg border-gray-200 text-sm focus:ring-red-500 focus:border-red-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Bulan</label>
                    <select name="month"
                        class="w-full rounded-lg border-gray-200 text-sm focus:ring-red-500 focus:border-red-500">
                        <option value="">Semua Bulan</option>
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                                {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Tahun</label>
                    <select name="year"
                        class="w-full rounded-lg border-gray-200 text-sm focus:ring-red-500 focus:border-red-500">
                        <option value="">Semua Tahun</option>
                        @foreach(range(date('Y'), date('Y') - 5) as $y)
                            <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-2">
                    <button type="submit"
                        class="flex-1 bg-red-600 text-white px-4 py-2 rounded-lg font-bold text-sm hover:bg-red-700 transition shadow-lg shadow-red-200">
                        Filter
                    </button>
                    <a href="{{ route('admin.complaints', ['status' => request('status')]) }}"
                        class="bg-gray-100 text-gray-600 px-4 py-2 rounded-lg font-bold text-sm hover:bg-gray-200 transition text-center">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        {{-- Filter Tabs --}}
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <nav class="flex space-x-2 p-2">
                <a href="{{ route('admin.complaints') }}"
                    class="flex-1 px-4 py-3 rounded-lg font-bold text-sm text-center transition-all {{ request('status') == null ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg' : 'text-gray-600 hover:bg-gray-100' }}">Semua</a>
                <a href="{{ route('admin.complaints') }}?status=open"
                    class="flex-1 px-4 py-3 rounded-lg font-bold text-sm text-center transition-all {{ request('status') == 'open' ? 'bg-gradient-to-r from-red-500 to-pink-500 text-white shadow-lg' : 'text-gray-600 hover:bg-gray-100' }}">Kendala</a>
                <a href="{{ route('admin.complaints') }}?status=in_progress"
                    class="flex-1 px-4 py-3 rounded-lg font-bold text-sm text-center transition-all {{ request('status') == 'in_progress' ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-lg' : 'text-gray-600 hover:bg-gray-100' }}">Sedang
                    Diproses</a>
                <a href="{{ route('admin.complaints') }}?status=resolved"
                    class="flex-1 px-4 py-3 rounded-lg font-bold text-sm text-center transition-all {{ request('status') == 'resolved' ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg' : 'text-gray-600 hover:bg-gray-100' }}">Selesai</a>
            </nav>
        </div>

        {{-- Complaints List Wrap --}}
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <div class="divide-y divide-gray-100">
                @forelse($complaints as $complaint)
                    {{-- Hidden Forms --}}
                    <form id="status-form-{{ $complaint->id }}" method="POST"
                        action="{{ route('admin.complaints.update', $complaint) }}" class="hidden">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" id="status-value-{{ $complaint->id }}">
                    </form>
                    <form id="delete-form-{{ $complaint->id }}" method="POST"
                        action="{{ route('admin.complaints.destroy', $complaint) }}" class="hidden">
                        @csrf @method('DELETE')
                    </form>

                    <div class="group hover:bg-gray-50 transition-all duration-300">
                        <div class="p-6">
                            <div class="flex flex-col md:flex-row items-start justify-between gap-6">
                                <div class="flex items-start space-x-4 flex-1">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="h-14 w-14 rounded-xl bg-gradient-to-br from-red-400 to-pink-500 flex items-center justify-center shadow-md ring-4 ring-white">
                                            <span
                                                class="text-xl font-bold text-white">{{ substr($complaint->user->name, 0, 1) }}</span>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3
                                            class="text-xl font-bold text-gray-900 group-hover:text-indigo-600 transition-colors mb-2">
                                            {{ $complaint->subject }}
                                        </h3>
                                        <div class="flex flex-wrap gap-2 mb-3">
                                            @if($complaint->status === 'resolved')
                                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">✓
                                                    Selesai</span>
                                            @elseif($complaint->status === 'in_progress')
                                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">⟳
                                                    Diproses</span>
                                            @elseif($complaint->status === 'closed')
                                                <span
                                                    class="px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-800">Ditutup</span>
                                            @else
                                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800">⚠
                                                    Kendala</span>
                                            @endif
                                            @if($complaint->priority === 'high')
                                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-50 text-red-600">🔴
                                                    Prioritas Tinggi</span>
                                            @elseif($complaint->priority === 'medium')
                                                <span
                                                    class="px-3 py-1 rounded-full text-xs font-bold bg-yellow-50 text-yellow-700">🟡
                                                    Prioritas Sedang</span>
                                            @else
                                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-gray-50 text-gray-500">⚪
                                                    Prioritas Rendah</span>
                                            @endif
                                        </div>
                                        <div class="text-sm text-gray-600 mb-3 flex flex-wrap items-center gap-y-1">
                                            <span class="font-bold text-gray-800">{{ $complaint->user->name }}</span>
                                            <span class="mx-2 text-gray-300">|</span>
                                            <span class="text-gray-600">Kamar {{ $complaint->user->room_number ?? '-' }}</span>
                                            <span class="mx-2 text-gray-300">|</span>
                                            <span
                                                class="text-gray-500">{{ $complaint->created_at->format('d F Y, H:i') }}</span>
                                        </div>
                                        <div class="bg-gray-50/80 p-4 rounded-xl border border-gray-100">
                                            <p class="text-sm text-gray-700 leading-relaxed">
                                                {{ Str::limit($complaint->description, 150) }}</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Action Buttons --}}
                                <div class="flex flex-row md:flex-col gap-2 w-full md:w-40">
                                    @if($complaint->status === 'open')
                                        <button type="button"
                                            @click="openStatus('{{ $complaint->id }}', '{{ addslashes($complaint->subject) }}', 'in_progress', 'Sedang Diproses')"
                                            class="flex-1 inline-flex items-center justify-center px-4 py-2 rounded-lg text-sm font-bold text-white bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 transition-all shadow-lg shadow-blue-100">
                                            Proses
                                        </button>
                                        <button type="button"
                                            @click="openStatus('{{ $complaint->id }}', '{{ addslashes($complaint->subject) }}', 'resolved', 'Selesai')"
                                            class="flex-1 inline-flex items-center justify-center px-4 py-2 rounded-lg text-sm font-bold text-white bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 transition-all shadow-lg shadow-green-100">
                                            Selesai
                                        </button>
                                    @elseif($complaint->status === 'in_progress')
                                        <button type="button"
                                            @click="openStatus('{{ $complaint->id }}', '{{ addslashes($complaint->subject) }}', 'resolved', 'Selesai')"
                                            class="flex-1 inline-flex items-center justify-center px-4 py-2 rounded-lg text-sm font-bold text-white bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 transition-all shadow-lg shadow-green-100">
                                            Selesai
                                        </button>
                                    @elseif($complaint->status === 'resolved')
                                        <button type="button"
                                            @click="openDelete('{{ $complaint->id }}', '{{ addslashes($complaint->subject) }}')"
                                            class="flex-1 inline-flex items-center justify-center px-4 py-2 rounded-lg text-sm font-bold text-white bg-gradient-to-r from-pink-600 to-red-600 hover:from-pink-700 hover:to-red-700 transition-all shadow-lg shadow-red-100">
                                            Hapus
                                        </button>
                                    @endif
                                    <a href="{{ route('admin.complaints.show', $complaint) }}"
                                        class="flex-1 inline-flex items-center justify-center px-4 py-2 rounded-lg text-sm font-bold text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 transition-all shadow-lg shadow-indigo-100">
                                        Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                        {{-- Hover Gradient Bar --}}
                        <div
                            class="h-1 bg-gradient-to-r from-red-500 via-pink-500 to-purple-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500">
                        </div>
                    </div>
                @empty
                    <div class="p-16 text-center">
                        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-50 mb-4">
                            <svg class="w-10 h-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Keluhan</h3>
                        <p class="text-gray-600">Keluhan dari penghuni akan muncul di sini</p>
                    </div>
                @endforelse
            </div>
        </div>

        @if(isset($complaints) && $complaints->hasPages())
            <div class="bg-white rounded-xl shadow-md px-4 py-3">{{ $complaints->links() }}</div>
        @endif

        {{-- STATUS CHANGE MODAL --}}
        <template x-teleport="body">
            <div x-show="statusModal" x-cloak class="fixed inset-0 z-[9999] flex items-center justify-center p-4"
                x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" @click="statusModal = false"></div>
                <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-sm overflow-hidden"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0">
                    <div class="bg-gradient-to-br from-indigo-600 to-purple-700 px-6 pt-8 pb-6 text-center">
                        <div
                            class="mx-auto w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mb-4 ring-4 ring-white/30">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-black text-white">Konfirmasi Perubahan Status</h3>
                        <p class="text-indigo-200 text-sm mt-1">Pastikan status yang dipilih sudah benar</p>
                    </div>
                    <div class="p-6">
                        <div class="bg-indigo-50 border border-indigo-100 rounded-2xl p-4 mb-5 space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 font-medium">Keluhan</span>
                                <span class="font-bold text-gray-900 text-right max-w-[180px] truncate"
                                    x-text="target.name"></span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 font-medium">Status Baru</span>
                                <span class="font-black text-indigo-700" x-text="target.statusLabel"></span>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <button @click="statusModal = false"
                                class="flex-1 px-4 py-3 border border-gray-200 rounded-xl text-sm font-bold text-gray-600 bg-white hover:bg-gray-50 transition">Batal</button>
                            <button
                                @click="document.getElementById('status-value-' + target.id).value = target.status; document.getElementById(target.formId).submit()"
                                class="flex-1 px-4 py-3 rounded-xl text-sm font-black text-white bg-gradient-to-r from-indigo-600 to-purple-700 shadow-lg shadow-indigo-500/30 transition transform hover:scale-[1.02]">Ya,
                                Ubah</button>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        {{-- DELETE COMPLAINT MODAL --}}
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
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-black text-white">Hapus Keluhan?</h3>
                        <p class="text-red-100 text-sm mt-1">Tindakan ini tidak dapat dibatalkan</p>
                    </div>
                    <div class="p-6">
                        <p class="text-sm text-gray-600 text-center font-medium mb-2">Anda akan menghapus keluhan:</p>
                        <p class="text-center font-bold text-gray-900 mb-5 text-sm" x-text="target.name"></p>
                        <p class="text-xs text-gray-400 text-center mb-6">Data keluhan akan terhapus secara permanen dan
                            tidak dapat dipulihkan.</p>
                        <div class="flex gap-3">
                            <button @click="deleteModal = false"
                                class="flex-1 px-4 py-3 border border-gray-200 rounded-xl text-sm font-bold text-gray-600 bg-white hover:bg-gray-50 transition">Batal</button>
                            <button @click="document.getElementById(target.deleteFormId).submit()"
                                class="flex-1 px-4 py-3 rounded-xl text-sm font-black text-white bg-gradient-to-r from-red-500 to-pink-600 shadow-lg shadow-red-500/30 transition transform hover:scale-[1.02]">Ya,
                                Hapus</button>
                        </div>
                    </div>
                </div>
        </template>
    </div>
@endsection