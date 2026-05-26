@extends('user.layout')

@section('content')
    <div style="background: var(--color-background-tertiary, #FFF9EB); min-height: 100vh; padding-bottom: 48px;">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
            <!-- Header -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 flex justify-between items-start">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Detail Keluhan #{{ $complaint->id }}
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            {{ $complaint->subject }}
                        </p>
                    </div>
                    <div class="flex items-center space-x-2">
                        @if($complaint->status === 'resolved')
                            <span class="px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                Selesai
                            </span>
                        @elseif($complaint->status === 'in_progress')
                            <span class="px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                Sedang Diproses
                            </span>
                        @elseif($complaint->status === 'closed')
                            <span class="px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                Ditutup
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                Kendala
                            </span>
                        @endif

                        @if($complaint->priority === 'high')
                            <span class="px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                Tinggi
                            </span>
                        @elseif($complaint->priority === 'medium')
                            <span class="px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                Sedang
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                Rendah
                            </span>
                        @endif
                    </div>
                </div>

                <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                    <dl class="sm:divide-y sm:divide-gray-200">
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Judul Keluhan</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $complaint->subject }}
                            </dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Kategori</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $complaint->category_label }}
                            </dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Prioritas</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $complaint->priority_label }}
                            </dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Tanggal Keluhan</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $complaint->created_at->format('d F Y, H:i') }}
                                <span class="text-gray-500">({{ $complaint->created_at->diffForHumans() }})</span>
                            </dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Deskripsi</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <div class="bg-gray-50 p-4 rounded-md border">
                                    {{ $complaint->description }}
                                </div>
                            </dd>
                        </div>
                        @if($complaint->admin_response)
                            <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Respon Admin</dt>
                                <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                                    <div class="bg-blue-50 border border-blue-200 p-4 rounded-md">
                                        <div class="text-blue-900">
                                            {{ $complaint->admin_response }}
                                        </div>
                                        @if($complaint->responded_at)
                                            <div class="mt-3 pt-3 border-t border-blue-200 text-xs text-blue-600">
                                                Direspon pada {{ $complaint->responded_at->format('d F Y, H:i') }}
                                            </div>
                                        @endif
                                    </div>
                                </dd>
                            </div>
                        @endif
                    </dl>
                </div>
            </div>

            <!-- Status Timeline -->
            <div class="bg-white shadow sm:rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Timeline Status</h3>

                    <div class="flow-root">
                        <ul class="-mb-8">
                            <!-- Keluhan Diajukan -->
                            <li>
                                <div class="relative pb-8">
                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200"
                                        aria-hidden="true"></span>
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span
                                                class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white">
                                                <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-500">Keluhan diajukan</p>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                {{ $complaint->created_at->format('d F Y, H:i') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <!-- Status Updates -->
                            @if($complaint->status === 'in_progress' || $complaint->status === 'resolved' || $complaint->status === 'closed')
                                <li>
                                    <div class="relative pb-8">
                                        @if($complaint->status === 'resolved' || $complaint->status === 'closed')
                                            <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200"
                                                aria-hidden="true"></span>
                                        @endif
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <span
                                                    class="h-8 w-8 rounded-full bg-yellow-500 flex items-center justify-center ring-8 ring-white">
                                                    <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                <div>
                                                    <p class="text-sm text-gray-500">Keluhan sedang diproses</p>
                                                </div>
                                                <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                    @if($complaint->responded_at)
                                                        {{ $complaint->responded_at->format('d F Y, H:i') }}
                                                    @else
                                                        -
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @elseif($complaint->status === 'closed')
                                <!-- Keluhan Ditutup -->
                                <li>
                                    <div class="relative">
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <span
                                                    class="h-8 w-8 rounded-full bg-gray-500 flex items-center justify-center ring-8 ring-white">
                                                    <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                <div>
                                                    <p class="text-sm text-gray-500">Keluhan ditutup</p>
                                                </div>
                                                <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                    @if($complaint->responded_at)
                                                        {{ $complaint->responded_at->format('d F Y, H:i') }}
                                                    @else
                                                        -
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Status Info -->
            @if($complaint->status === 'open')
                <div class="bg-red-50 border border-red-200 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Menunggu Tanggapan Admin</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <p>Keluhan Anda sudah diterima dan akan segera ditanggapi oleh admin. Mohon bersabar dan pantau
                                    status keluhan ini secara berkala.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($complaint->status === 'in_progress')
                <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Keluhan Sedang Diproses</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <p>Admin sedang menangani keluhan Anda. Kami akan memberikan update terbaru secepatnya. Terima
                                    kasih
                                    atas kesabaran Anda.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($complaint->status === 'resolved')
                <div class="bg-green-50 border border-green-200 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-green-800">Keluhan Telah Selesai</h3>
                            <div class="mt-2 text-sm text-green-700">
                                <p>Selamat! Keluhan Anda telah berhasil diselesaikan oleh admin. Jika masih ada masalah terkait
                                    hal
                                    yang sama, jangan ragu untuk mengajukan keluhan baru.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($complaint->status === 'closed')
                <div class="bg-gray-50 border border-gray-200 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-gray-800">Keluhan Ditutup</h3>
                            <div class="mt-2 text-sm text-gray-700">
                                <p>Keluhan ini telah ditutup oleh admin. Jika Anda merasa masalah belum terselesaikan dengan
                                    baik,
                                    silakan ajukan keluhan baru dengan penjelasan yang lebih detail.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="flex justify-center space-x-4">
                <a href="{{ route('user.public-complaints') }}"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18">
                        </path>
                    </svg>
                    Kembali ke Keluhan Umum
                </a>

                @if($complaint->status === 'closed' || $complaint->status === 'resolved')
                    <a href="{{ route('user.complaints.create') }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                            </path>
                        </svg>
                        Ajukan Keluhan Baru
                    </a>
                @endif
            </div>
        </div>
    </div>
@endsection