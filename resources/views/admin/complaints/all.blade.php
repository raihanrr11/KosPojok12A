@extends('admin.layout')

@section('content')
<div class="space-y-6">

    {{-- Simplified Header --}}
    <div class="flex items-center justify-between pb-6 border-b border-gray-200">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Semua Aktivitas Keluhan</h1>
            <p class="mt-1 text-sm text-gray-500">Riwayat lengkap seluruh keluhan dari semua penghuni</p>
        </div>
        <a href="{{ route('admin.complaints') }}"
            class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
        <form action="{{ route('admin.complaints.all') }}" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
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
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Tanggal Spesifik</label>
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
                    class="flex-1 bg-red-600 text-white px-4 py-2 rounded-lg font-bold text-sm hover:bg-red-700 transition">
                    Filter
                </button>
                <a href="{{ route('admin.complaints.all', ['status' => request('status')]) }}"
                    class="bg-gray-100 text-gray-600 px-4 py-2 rounded-lg font-bold text-sm hover:bg-gray-200 transition text-center">
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Minimalist Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Subjek</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Penghuni</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Prioritas</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Aksi</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($complaints as $complaint)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900">{{ Str::limit($complaint->subject, 30) }}</div>
                                @if($complaint->is_public)
                                    <span class="text-[10px] uppercase font-bold text-indigo-600">Public</span>
                                @else
                                    <span class="text-[10px] uppercase font-bold text-gray-400">Private</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $complaint->user->name }}</div>
                                <div class="text-xs text-gray-500">Kamar {{ $complaint->user->room_number ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $complaint->created_at->format('d/m/Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $complaint->created_at->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($complaint->priority === 'high')
                                    <span class="px-2 py-1 text-xs font-medium bg-red-50 text-red-700 rounded-md">Tinggi</span>
                                @elseif($complaint->priority === 'medium')
                                    <span class="px-2 py-1 text-xs font-medium bg-yellow-50 text-yellow-700 rounded-md">Sedang</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-medium bg-gray-50 text-gray-700 rounded-md">Rendah</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($complaint->status === 'resolved')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Selesai</span>
                                @elseif($complaint->status === 'in_progress')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Diproses</span>
                                @elseif($complaint->status === 'closed')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Ditutup</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Kendala</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.complaints.show', $complaint) }}" class="text-indigo-600 hover:text-indigo-900">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500 text-sm">
                                Belum ada data keluhan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
