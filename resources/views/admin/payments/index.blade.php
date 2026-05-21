@extends('admin.layout')

@section('content')
    <div class="space-y-6" x-data="{
            verifyModal: false,
            rejectModal: false,
            rejectReason: '',
            rejectError: false,
            targetPayment: { id: '', name: '', amount: '', verifyFormId: '', rejectFormId: '' },
            openVerify(id, name, amount) {
                this.targetPayment = { id, name, amount, verifyFormId: 'verify-form-' + id, rejectFormId: 'reject-form-' + id };
                this.verifyModal = true;
            },
            openReject(id, name, amount) {
                this.rejectReason = '';
                this.rejectError = false;
                this.targetPayment = { id, name, amount, verifyFormId: 'verify-form-' + id, rejectFormId: 'reject-form-' + id };
                this.rejectModal = true;
            },
            submitReject() {
                if (!this.rejectReason.trim()) { this.rejectError = true; return; }
                document.getElementById('reject-reason-' + this.targetPayment.id).value = this.rejectReason;
                document.getElementById(this.targetPayment.rejectFormId).submit();
            }
        }">

        {{-- Header --}}
        <div
            class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 p-8 shadow-xl">
            <div class="relative z-10 pr-48">
                <h1 class="text-3xl font-bold text-white">Manajemen Pembayaran</h1>
                <p class="mt-2 text-green-100">Kelola dan verifikasi pembayaran dari seluruh penghuni dengan cepat</p>
            </div>
            <div class="absolute top-6 right-6 z-20">
                <a href="{{ route('admin.payments.all') }}"
                    class="bg-white/20 hover:bg-white/30 backdrop-blur-md border border-white/30 text-white px-4 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center gap-2 shadow-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                    </svg>
                    Lihat Semua
                </a>
            </div>
            <div class="absolute top-0 right-0 -mt-4 -mr-4 h-32 w-32 rounded-full bg-white opacity-10"></div>
            <div class="absolute bottom-0 left-0 -mb-8 -ml-8 h-40 w-40 rounded-full bg-white opacity-5"></div>
            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div style="background: rgba(255,255,255,0.12); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.25); box-shadow: inset 0 1px 0 rgba(255,255,255,0.2), 0 4px 16px rgba(0,0,0,0.1);"
    class="rounded-xl p-4">
    <div class="text-white/80 text-sm font-semibold mb-1">Total Pembayaran</div>
    <div class="text-2xl font-black text-white mt-1">{{ $payments->total() }}</div>
</div>

<div style="background: rgba(255,255,255,0.12); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.25); box-shadow: inset 0 1px 0 rgba(255,255,255,0.2), 0 4px 16px rgba(0,0,0,0.1);"
    class="rounded-xl p-4">
    <div class="text-white/80 text-sm font-semibold mb-1">Menunggu Verifikasi</div>
    <div class="text-2xl font-black text-white mt-1">{{ $payments->where('status', 'pending')->count() }}</div>
</div>

<div style="background: rgba(255,255,255,0.12); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.25); box-shadow: inset 0 1px 0 rgba(255,255,255,0.2), 0 4px 16px rgba(0,0,0,0.1);"
    class="rounded-xl p-4">
    <div class="text-white/80 text-sm font-semibold mb-1">Terverifikasi</div>
    <div class="text-2xl font-black text-white mt-1">{{ $payments->where('status', 'verified')->count() }}</div>
</div>
            </div>
        </div>

        {{-- Name Search Filter --}}
        <div class="bg-white rounded-xl shadow-md p-4">
            <form action="{{ route('admin.payments') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                
                <div class="w-full md:flex-1">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Cari Nama</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama penghuni..."
                        class="w-full rounded-lg border-gray-200 text-sm focus:ring-green-500 focus:border-green-500">
                </div>

                <div class="flex gap-2 w-full md:w-auto">
                    <button type="submit" class="flex-1 md:flex-none bg-green-600 text-white px-6 py-2 rounded-lg font-bold text-sm hover:bg-green-700 transition shadow-lg shadow-green-200">
                        Cari
                    </button>
                    <a href="{{ route('admin.payments', ['status' => request('status')]) }}" class="flex-1 md:flex-none bg-gray-100 text-gray-600 px-6 py-2 rounded-lg font-bold text-sm hover:bg-gray-200 transition text-center flex items-center justify-center">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        {{-- Filter Tabs --}}
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <nav class="flex space-x-2 p-2">
                <a href="{{ route('admin.payments', ['month' => date('n'), 'year' => date('Y')]) }}"
                    class="flex-1 px-4 py-3 rounded-lg font-bold text-sm text-center transition-all duration-300 {{ (request('month') == date('n') && request('year') == date('Y') && request('status') == null) ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg' : 'text-gray-600 hover:bg-gray-100' }}">Bulan Ini</a>
                <a href="{{ route('admin.payments') }}?status=pending"
                    class="flex-1 px-4 py-3 rounded-lg font-bold text-sm text-center transition-all duration-300 {{ request('status') == 'pending' ? 'bg-gradient-to-r from-yellow-500 to-orange-500 text-white shadow-lg' : 'text-gray-600 hover:bg-gray-100' }}">Pending</a>
                <a href="{{ route('admin.payments') }}?status=verified"
                    class="flex-1 px-4 py-3 rounded-lg font-bold text-sm text-center transition-all duration-300 {{ request('status') == 'verified' ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg' : 'text-gray-600 hover:bg-gray-100' }}">Terverifikasi</a>
                <a href="{{ route('admin.payments') }}?status=rejected"
                    class="flex-1 px-4 py-3 rounded-lg font-bold text-sm text-center transition-all duration-300 {{ request('status') == 'rejected' ? 'bg-gradient-to-r from-red-500 to-pink-500 text-white shadow-lg' : 'text-gray-600 hover:bg-gray-100' }}">Ditolak</a>
                <a href="{{ route('admin.payments') }}?status=unpaid"
                    class="flex-1 px-4 py-3 rounded-lg font-bold text-sm text-center transition-all duration-300 {{ request('status') == 'unpaid' ? 'bg-gradient-to-r from-gray-500 to-slate-500 text-white shadow-lg' : 'text-gray-600 hover:bg-gray-100' }}">Belum Bayar</a>
            </nav>
        </div>

        {{-- Payments List --}}
        {{-- Payments List Wrap --}}
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <div class="divide-y divide-gray-100">
                @forelse($payments as $payment)
                    {{-- Hidden Forms for this payment --}}
                    <form id="verify-form-{{ $payment->id }}" method="POST" action="{{ route('admin.payments.verify', $payment) }}"
                        class="hidden">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="verified">
                    </form>
                    <form id="reject-form-{{ $payment->id }}" method="POST" action="{{ route('admin.payments.verify', $payment) }}"
                        class="hidden">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="rejected">
                        <input type="hidden" name="admin_notes" id="reject-reason-{{ $payment->id }}">
                    </form>

                    <div class="group hover:bg-gray-50 transition-all duration-300">
                        <div class="p-6">
                            <div class="flex flex-col md:flex-row items-start justify-between gap-6">
                                <div class="flex items-start space-x-4 flex-1">
                                    <div class="flex-shrink-0">
                                        @if($payment->user->photo)
                                            <img src="{{ Storage::url($payment->user->photo) }}" alt="{{ $payment->user->name }}"
                                                class="h-16 w-16 rounded-xl object-cover shadow-md ring-4 ring-white">
                                        @else
                                            <div
                                                class="h-16 w-16 rounded-xl bg-gradient-to-br from-green-400 to-emerald-500 flex items-center justify-center shadow-md ring-4 ring-white">
                                                <span
                                                    class="text-2xl font-bold text-white">{{ substr($payment->user->name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center space-x-3 mb-2">
                                            <h3
                                                class="text-2xl font-bold text-gray-900 group-hover:text-green-600 transition-colors">
                                                Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                            </h3>
                                            @if($payment->status === 'verified')
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">✓
                                                    Terverifikasi</span>
                                            @elseif($payment->status === 'rejected')
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800">✗
                                                    Ditolak</span>
                                            @elseif($payment->status === 'pending')
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800 animate-pulse">⏱
                                                    Pending</span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-800">⚠
                                                    Belum Bayar</span>
                                            @endif
                                        </div>
                                        <div class="flex items-center space-x-4 text-sm mb-3">
                                            <span class="font-bold text-gray-700">{{ $payment->user->name }}</span>
                                            <span class="text-gray-400">•</span>
                                            <span class="text-gray-600">Kamar {{ $payment->user->room_number }}</span>
                                        </div>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                            <div class="bg-blue-50/50 p-3 rounded-lg border border-blue-100/50">
                                                <div class="text-xs text-indigo-600 font-bold mb-1">Tanggal Pembayaran</div>
                                                <div class="text-sm text-gray-900 font-bold">
                                                    {{ $payment->payment_date->format('d F Y') }}</div>
                                            </div>
                                            <div class="bg-purple-50/50 p-3 rounded-lg border border-purple-100/50">
                                                <div class="text-xs text-purple-600 font-bold mb-1">Metode</div>
                                                <div class="text-sm text-gray-900 font-bold">
                                                    {{ ucwords(str_replace('_', ' ', $payment->payment_method)) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Action Buttons --}}
                                <div class="flex flex-row md:flex-col gap-2 w-full md:w-40">
                                    @if($payment->status === 'pending')
                                        <button type="button"
                                            @click="openVerify('{{ $payment->id }}', '{{ addslashes($payment->user->name) }}', 'Rp {{ number_format($payment->amount, 0, ',', '.') }}')"
                                            class="flex-1 inline-flex items-center justify-center px-4 py-2 rounded-lg text-sm font-bold text-white bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 transition-all shadow-lg shadow-green-200">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            Verifikasi
                                        </button>
                                        <button type="button"
                                            @click="openReject('{{ $payment->id }}', '{{ addslashes($payment->user->name) }}', 'Rp {{ number_format($payment->amount, 0, ',', '.') }}')"
                                            class="flex-1 inline-flex items-center justify-center px-4 py-2 rounded-lg text-sm font-bold text-white bg-gradient-to-r from-red-600 to-pink-600 hover:from-red-700 hover:to-pink-700 transition-all shadow-lg shadow-red-200">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Tolak
                                        </button>
                                    @endif
                                    @if($payment->status === 'unpaid')
                                        <a href="{{ route('admin.users.show', $payment->user) }}"
                                            class="flex-1 inline-flex items-center justify-center px-4 py-2 rounded-lg text-sm font-bold text-gray-700 bg-gray-100 hover:bg-gray-200 transition-all shadow-lg shadow-gray-200">
                                            Profil
                                        </a>
                                    @else
                                        <a href="{{ route('admin.payments.show', $payment) }}"
                                            class="flex-1 inline-flex items-center justify-center px-4 py-2 rounded-lg text-sm font-bold text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 transition-all shadow-lg shadow-indigo-200">
                                            Detail
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-16 text-center">
                        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-50 mb-4">
                            <svg class="w-10 h-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Pembayaran</h3>
                        <p class="text-gray-600">Pembayaran dari penghuni akan muncul di sini</p>
                    </div>
                @endforelse
            </div>
        </div>

        @if($payments->hasPages())
            <div class="bg-white rounded-xl shadow-md px-4 py-3">{{ $payments->links() }}</div>
        @endif

        {{-- VERIFY MODAL --}}
        <template x-teleport="body">
            <div x-show="verifyModal" x-cloak class="fixed inset-0 z-[9999] flex items-center justify-center p-4"
                x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" @click="verifyModal = false"></div>
                <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-sm overflow-hidden"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0">
                    <div class="bg-gradient-to-br from-green-500 to-emerald-600 px-6 pt-8 pb-6 text-center">
                        <div
                            class="mx-auto w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mb-4 ring-4 ring-white/30">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-black text-white">Konfirmasi Verifikasi</h3>
                        <p class="text-green-100 text-sm mt-1">Tindakan ini tidak dapat dibatalkan</p>
                    </div>
                    <div class="p-6">
                        <div class="bg-green-50 border border-green-100 rounded-2xl p-4 mb-5 space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 font-medium">Penghuni</span>
                                <span class="font-black text-gray-900" x-text="targetPayment.name"></span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 font-medium">Jumlah</span>
                                <span class="font-black text-green-700" x-text="targetPayment.amount"></span>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <button @click="verifyModal = false"
                                class="flex-1 px-4 py-3 border border-gray-200 rounded-xl text-sm font-bold text-gray-600 bg-white hover:bg-gray-50 transition">Batal</button>
                            <button @click="document.getElementById(targetPayment.verifyFormId).submit()"
                                class="flex-1 px-4 py-3 rounded-xl text-sm font-black text-white bg-gradient-to-r from-green-500 to-emerald-600 shadow-lg shadow-green-500/30 transition transform hover:scale-[1.02]">Ya,
                                Verifikasi</button>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        {{-- REJECT MODAL --}}
        <template x-teleport="body">
        <div x-show="rejectModal" x-cloak class="fixed inset-0 z-[9999] flex items-center justify-center p-4"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" @click="rejectModal = false"></div>
            <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0">
                <div class="bg-gradient-to-br from-red-500 to-pink-600 px-6 pt-8 pb-6 text-center">
                    <div
                        class="mx-auto w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mb-4 ring-4 ring-white/30">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-black text-white">Tolak Pembayaran</h3>
                    <p class="text-red-100 text-sm mt-1">Berikan alasan yang jelas untuk penghuni</p>
                </div>
                <div class="p-6">
                    <div class="bg-red-50 border border-red-100 rounded-xl p-3 mb-4 flex justify-between text-sm">
                        <span class="text-gray-500 font-medium">Penghuni</span>
                        <span class="font-black text-gray-900" x-text="targetPayment.name"></span>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-1.5">Alasan Penolakan <span
                                class="text-red-500">*</span></label>
                        <textarea x-model="rejectReason" @input="rejectError = false" rows="4"
                            placeholder="Contoh: Bukti tidak terbaca, nominal tidak sesuai..."
                            :class="rejectError ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-gray-50'"
                            class="block w-full rounded-xl border px-4 py-3 text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:bg-white transition resize-none"></textarea>
                        <p x-show="rejectError" x-transition
                            class="mt-1.5 flex items-center gap-1.5 text-xs font-semibold text-red-600">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            Alasan penolakan wajib diisi!
                        </p>
                    </div>
                    <div class="flex gap-3">
                        <button @click="rejectModal = false; rejectError = false"
                            class="flex-1 px-4 py-3 border border-gray-200 rounded-xl text-sm font-bold text-gray-600 bg-white hover:bg-gray-50 transition">Batal</button>
                        <button @click="submitReject()"
                            class="flex-1 px-4 py-3 rounded-xl text-sm font-black text-white bg-gradient-to-r from-red-500 to-pink-600 shadow-lg shadow-red-500/30 transition transform hover:scale-[1.02]">Ya,
                            Tolak</button>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>
@endsection