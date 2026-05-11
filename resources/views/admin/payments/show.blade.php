@extends('admin.layout')

@section('content')
<div class="max-w-4xl mx-auto space-y-6" x-data="{ verifyModal: false, rejectModal: false, rejectReason: '', rejectError: false }">
    <!-- Header with Back Button -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Detail Pembayaran #{{ $payment->id }}</h2>
            <p class="mt-1 text-sm text-gray-600">Kelola verifikasi pembayaran penghuni kos</p>
        </div>
        <a href="{{ route('admin.payments') }}"
            class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </div>

    <!-- Payment Details Card -->
    <div class="bg-white shadow-xl rounded-3xl overflow-hidden border border-gray-100">
        <div class="px-6 py-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <div>
                <h3 class="text-lg font-bold text-gray-900 tracking-tight">Informasi Pembayaran</h3>
                <p class="text-sm text-gray-500">Detail lengkap pembayaran dari {{ $payment->user->name }}</p>
            </div>
            <div>
                @if($payment->status === 'verified')
                    <span class="px-4 py-1.5 rounded-full text-xs font-black bg-green-100 text-green-800 uppercase tracking-wider">✓ Terverifikasi</span>
                @elseif($payment->status === 'rejected')
                    <span class="px-4 py-1.5 rounded-full text-xs font-black bg-red-100 text-red-800 uppercase tracking-wider">✗ Ditolak</span>
                @else
                    <span class="px-4 py-1.5 rounded-full text-xs font-black bg-yellow-100 text-yellow-800 uppercase tracking-wider animate-pulse">⏱ Pending</span>
                @endif
            </div>
        </div>

        <div class="p-6 sm:p-8">
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-6">
                <div class="space-y-1">
                    <dt class="text-xs font-black text-gray-400 uppercase tracking-widest">Nama Penghuni</dt>
                    <dd class="text-base font-bold text-gray-900">{{ $payment->user->name }}</dd>
                </div>
                <div class="space-y-1">
                    <dt class="text-xs font-black text-gray-400 uppercase tracking-widest">Email</dt>
                    <dd class="text-base font-medium text-gray-600">{{ $payment->user->email }}</dd>
                </div>
                <div class="space-y-1">
                    <dt class="text-xs font-black text-gray-400 uppercase tracking-widest">Nomor Kamar</dt>
                    <dd class="text-base font-bold text-indigo-600">{{ $payment->user->room_number ?? '-' }}</dd>
                </div>
                <div class="space-y-1">
                    <dt class="text-xs font-black text-gray-400 uppercase tracking-widest">Jumlah Pembayaran</dt>
                    <dd class="text-xl font-black text-gray-900">Rp {{ number_format($payment->amount, 0, ',', '.') }}</dd>
                </div>
                <div class="space-y-1">
                    <dt class="text-xs font-black text-gray-400 uppercase tracking-widest">Tanggal Pembayaran</dt>
                    <dd class="text-base font-medium text-gray-900">{{ $payment->payment_date->format('d F Y') }}</dd>
                </div>
                <div class="space-y-1">
                    <dt class="text-xs font-black text-gray-400 uppercase tracking-widest">Metode</dt>
                    <dd>
                        <span class="px-3 py-1 rounded-lg text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100 uppercase">{{ $payment->payment_method }}</span>
                    </dd>
                </div>

                @if($payment->description)
                <div class="sm:col-span-2 space-y-1 pt-4 border-t border-gray-50">
                    <dt class="text-xs font-black text-gray-400 uppercase tracking-widest">Deskripsi Penghuni</dt>
                    <dd class="text-sm text-gray-700 leading-relaxed">{{ $payment->description }}</dd>
                </div>
                @endif

                @if($payment->status === 'rejected' && $payment->admin_notes)
                <div class="sm:col-span-2 space-y-1 pt-4">
                    <dt class="text-xs font-black text-red-400 uppercase tracking-widest">Alasan Penolakan Admin</dt>
                    <dd class="bg-red-50 border border-red-100 rounded-2xl p-4 text-sm text-red-800 font-medium italic">
                        "{{ $payment->admin_notes }}"
                    </dd>
                </div>
                @endif

                <!-- Proof of Payment -->
                <div class="sm:col-span-2 pt-6 border-t border-gray-50">
                    <dt class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Bukti Pembayaran</dt>
                    <dd>
                        @if($payment->proof_file)
                            @if(Str::endsWith($payment->proof_file, ['.jpg', '.jpeg', '.png', '.gif']))
                                <div class="relative group max-w-lg">
                                    <img src="{{ Storage::url($payment->proof_file) }}" alt="Bukti Pembayaran"
                                        class="rounded-3xl border-4 border-white shadow-2xl transition-transform group-hover:scale-[1.02] duration-500">
                                    <a href="{{ Storage::url($payment->proof_file) }}" target="_blank"
                                        class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center rounded-3xl backdrop-blur-sm">
                                        <span class="bg-white px-6 py-3 rounded-2xl font-black text-gray-900 shadow-xl transform translate-y-4 group-hover:translate-y-0 transition-transform">
                                            Lihat Layar Penuh
                                        </span>
                                    </a>
                                </div>
                            @else
                                <a href="{{ Storage::url($payment->proof_file) }}" target="_blank"
                                    class="inline-flex items-center px-6 py-4 rounded-2xl bg-indigo-50 border border-indigo-100 text-indigo-700 hover:bg-indigo-100 transition-all font-bold">
                                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Unduh Bukti Pembayaran (PDF)
                                </a>
                            @endif
                        @endif
                    </dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Verification Actions -->
    @if($payment->status === 'pending')
        <div class="bg-white p-8 rounded-3xl shadow-xl border border-gray-100">
            <h3 class="text-lg font-black text-gray-900 mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                Tindakan Verifikasi Admin
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <button type="button" @click="verifyModal = true"
                    class="group relative inline-flex items-center justify-center px-6 py-4 rounded-2xl font-black text-white bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 shadow-lg shadow-green-500/25 transition-all transform hover:scale-[1.02]">
                    <svg class="w-6 h-6 mr-2 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    Verifikasi Pembayaran
                </button>
                <button type="button" @click="rejectModal = true"
                    class="group relative inline-flex items-center justify-center px-6 py-4 rounded-2xl font-black text-white bg-gradient-to-r from-red-600 to-pink-600 hover:from-red-700 hover:to-pink-700 shadow-lg shadow-red-500/25 transition-all transform hover:scale-[1.02]">
                    <svg class="w-6 h-6 mr-2 group-hover:-rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                    Tolak Pembayaran
                </button>
            </div>
        </div>
    @endif

    {{-- VERIFY MODAL --}}
    <template x-teleport="body">
        <div x-show="verifyModal" x-cloak class="fixed inset-0 z-[9999] flex items-center justify-center p-4"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" @click="verifyModal = false"></div>
        <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-sm overflow-hidden"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0">
            <div class="bg-gradient-to-br from-green-500 to-emerald-600 px-6 pt-8 pb-6 text-center">
                <div class="mx-auto w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mb-4 ring-4 ring-white/30">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-black text-white">Konfirmasi Verifikasi</h3>
                <p class="text-green-100 text-sm mt-1">Tindakan ini tidak dapat dibatalkan</p>
            </div>
            <div class="p-6">
                <p class="text-sm text-gray-600 text-center mb-6">Pastikan bukti pembayaran sudah sesuai dengan tagihan.</p>
                <form action="{{ route('admin.payments.verify', $payment) }}" method="POST">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="verified">
                    <div class="flex gap-3">
                        <button type="button" @click="verifyModal = false" class="flex-1 px-4 py-3 border border-gray-200 rounded-xl text-sm font-bold text-gray-600 bg-white hover:bg-gray-50 transition">Batal</button>
                        <button type="submit" class="flex-1 px-4 py-3 rounded-xl text-sm font-black text-white bg-gradient-to-r from-green-500 to-emerald-600 shadow-lg shadow-green-500/30 transition transform hover:scale-[1.02]">Ya, Verifikasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

    {{-- REJECT MODAL --}}
    <template x-teleport="body">
        <div x-show="rejectModal" x-cloak class="fixed inset-0 z-[9999] flex items-center justify-center p-4"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" @click="rejectModal = false"></div>
        <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0">
            <div class="bg-gradient-to-br from-red-500 to-pink-600 px-6 pt-8 pb-6 text-center">
                <div class="mx-auto w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mb-4 ring-4 ring-white/30">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
                <h3 class="text-xl font-black text-white">Tolak Pembayaran</h3>
                <p class="text-red-100 text-sm mt-1">Berikan alasan yang jelas untuk penghuni</p>
            </div>
            <div class="p-6">
                <form action="{{ route('admin.payments.verify', $payment) }}" method="POST">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="rejected">
                    <div class="mb-4">
                        <label for="admin_notes" class="block text-sm font-bold text-gray-700 mb-1.5 ml-1">Alasan Penolakan <span class="text-red-500">*</span></label>
                        <textarea name="admin_notes" id="admin_notes" x-model="rejectReason" @input="rejectError = false" rows="4" required
                            placeholder="Contoh: Bukti tidak terbaca, nominal tidak sesuai..."
                            :class="rejectError ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-gray-50'"
                            class="block w-full rounded-2xl border px-4 py-3 text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:bg-white transition resize-none shadow-inner"></textarea>
                        <p x-show="rejectError" x-transition class="mt-1.5 flex items-center gap-1.5 text-xs font-semibold text-red-600">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            Alasan penolakan wajib diisi!
                        </p>
                    </div>
                    <div class="flex gap-3">
                        <button type="button" @click="rejectModal = false; rejectError = false" class="flex-1 px-4 py-3 border border-gray-200 rounded-xl text-sm font-bold text-gray-600 bg-white hover:bg-gray-50 transition">Batal</button>
                        <button type="submit" @click="if(!rejectReason.trim()){ $event.preventDefault(); rejectError = true; }"
                            class="flex-1 px-4 py-3 rounded-xl text-sm font-black text-white bg-gradient-to-r from-red-500 to-pink-600 shadow-lg shadow-red-500/30 transition transform hover:scale-[1.02]">Ya, Tolak</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
</div>
@endsection