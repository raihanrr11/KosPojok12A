@extends('admin.layout')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-6">Edit Penghuni: {{ $user->name }}</h3>
            
            <form method="POST" action="{{ route('admin.users.update', $user) }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
                
                <!-- Photo Upload Section -->
                <div class="flex items-center space-x-6">
                    <div class="flex-shrink-0">
                        <div id="photo-preview" class="h-32 w-32 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden">
                            @if($user->photo)
                                <img src="{{ Storage::url($user->photo) }}" alt="{{ $user->name }}" class="h-full w-full object-cover">
                            @else
                                <div class="h-full w-full flex items-center justify-center bg-indigo-100">
                                    <span class="text-3xl font-medium text-indigo-700">{{ $user->initials }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="flex-1">
                        <label for="photo" class="block text-sm font-medium text-gray-700">Foto Penghuni</label>
                        <div class="mt-1">
                            <input type="file" name="photo" id="photo" accept="image/jpeg,image/jpg,image/png" 
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                                   onchange="previewPhoto(event)">
                        </div>
                        <p class="mt-2 text-xs text-gray-500">Format: JPG, JPEG, PNG. Maksimal 2MB</p>
                        @if($user->photo)
                        <div class="mt-2">
                            <a href="{{ route('admin.users.delete-photo', $user) }}" 
                               onclick="return confirm('Hapus foto penghuni?')"
                               class="text-sm text-red-600 hover:text-red-900">
                                Hapus Foto Saat Ini
                            </a>
                        </div>
                        @endif
                        @error('photo')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-6">
                    <h4 class="text-md font-medium text-gray-900 mb-4">Data Pribadi</h4>
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap *</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required 
                                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('name') border-red-300 @enderror">
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required 
                                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('email') border-red-300 @enderror">
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">No. Telepon</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
                                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('phone') border-red-300 @enderror">
                            @error('phone')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                            <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth?->format('Y-m-d')) }}"
                                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('date_of_birth') border-red-300 @enderror">
                            @error('date_of_birth')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="emergency_contact" class="block text-sm font-medium text-gray-700">Kontak Darurat</label>
                            <input type="text" name="emergency_contact" id="emergency_contact" value="{{ old('emergency_contact', $user->emergency_contact) }}"
                                   placeholder="Nama & No. HP (contoh: Ibu Siti - 08123456789)"
                                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('emergency_contact') border-red-300 @enderror">
                            @error('emergency_contact')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="address" class="block text-sm font-medium text-gray-700">Alamat Asal</label>
                        <textarea name="address" id="address" rows="2" 
                                  class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('address') border-red-300 @enderror">{{ old('address', $user->address) }}</textarea>
                        @error('address')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-6">
                    <h4 class="text-md font-medium text-gray-900 mb-4">Informasi Kos</h4>
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="room_number" class="block text-sm font-medium text-gray-700">Nomor Kamar *</label>
                            <select name="room_number" id="room_number" required
                                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('room_number') border-red-300 @enderror">
                                <option value="">-- Pilih Kamar --</option>
                                @foreach($availableRooms as $room)
                                    <option value="{{ $room->room_number }}" {{ old('room_number', $user->room_number) == $room->room_number ? 'selected' : '' }} data-price="{{ $room->price }}">
                                        Kamar {{ $room->room_number }} - Rp {{ number_format($room->price, 0, ',', '.') }}/bulan {{ $room->room_number == $user->room_number ? '(Saat Ini)' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('room_number')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="monthly_rent" class="block text-sm font-medium text-gray-700">Sewa Bulanan (Rp) *</label>
                            <input type="number" name="monthly_rent" id="monthly_rent" value="{{ old('monthly_rent', $user->monthly_rent) }}" readonly
                                   class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md bg-gray-100 cursor-not-allowed font-semibold text-gray-500 @error('monthly_rent') border-red-300 @enderror">
                            <p class="mt-1 text-xs text-gray-500">Harga sewa bulanan otomatis ditentukan oleh harga kamar yang dipilih.</p>
                            @error('monthly_rent')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                <strong>Catatan:</strong> Password tidak akan berubah kecuali penghuni mengganti sendiri melalui profil mereka.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.users') }}" 
                       class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Batal
                    </a>
                    <button type="submit" 
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Update Data Penghuni
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewPhoto(event) {
    const preview = document.getElementById('photo-preview');
    const file = event.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = '<img src="' + e.target.result + '" class="h-full w-full object-cover" />';
        }
        reader.readAsDataURL(file);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const roomNumberInput = document.getElementById('room_number');
    const monthlyRentInput = document.getElementById('monthly_rent');

    roomNumberInput.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption && selectedOption.dataset.price) {
            monthlyRentInput.value = selectedOption.dataset.price;
        }
    });
});
</script>
@endsection