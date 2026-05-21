@extends(auth()->user()->isAdmin() ? 'admin.layout' : 'user.layout')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">
        {{-- Header Section --}}
        <div class="flex items-center justify-between pb-6 border-b border-gray-200">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    {{ auth()->user()->isAdmin() ? 'Pengaturan Profil' : 'Ubah Password' }}
                </h1>
                <p class="mt-1 text-sm text-gray-500">
                    {{ auth()->user()->isAdmin() ? 'Kelola data profil dan keamanan akun Anda.' : 'Perbarui kata sandi akun Anda demi keamanan.' }}
                </p>
            </div>
            <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('user.profile') }}"
                class="inline-flex items-center px-4 py-2.5 border border-gray-300 shadow-sm text-sm font-bold rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>

        <div class="space-y-6">
            @if(auth()->user()->isAdmin())
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
            @endif

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            @if(auth()->user()->isAdmin())
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection
