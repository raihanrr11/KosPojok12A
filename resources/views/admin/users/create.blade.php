@extends('admin.layout')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-6">Tambah Penghuni Baru</h3>

                <!-- Alert untuk validasi Server-side -->
                @if($errors->any())
                    <div
                        class="mb-6 rounded-lg border-2 border-red-500 bg-red-50 text-red-800 px-4 py-3 shadow-lg animate-shake">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 flex-shrink-0 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                            <div class="flex-1">
                                <p class="font-bold text-base mb-2">Terjadi Kesalahan!</p>
                                <ul class="space-y-1.5 text-sm font-medium">
                                    @foreach($errors->all() as $error)
                                        <li class="flex items-start gap-2">
                                            <span class="text-red-600 font-bold mt-0.5">•</span>
                                            <span>{{ $error }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Alert untuk validasi JavaScript (client-side) -->
                <div id="jsErrorAlert"
                    class="mb-6 rounded-lg border-2 border-red-500 bg-red-50 text-red-800 px-4 py-3 shadow-lg animate-shake hidden">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 flex-shrink-0 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                        <div class="flex-1">
                            <p class="font-bold text-base mb-2">Terjadi Kesalahan!</p>
                            <ul id="jsErrorList" class="space-y-1.5 text-sm font-medium"></ul>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data" id="userForm"
                    class="space-y-6">
                    @csrf

                    <!-- Photo Upload Section -->
                    <div class="flex items-center space-x-6">
                        <div class="flex-shrink-0">
                            <div id="photo-preview"
                                class="h-32 w-32 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden">
                                <svg class="h-16 w-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <label for="photo" class="block text-sm font-medium text-gray-700">Foto Penghuni</label>
                            <div class="mt-1 flex items-center">
                                <input type="file" name="photo" id="photo" accept="image/jpeg,image/jpg,image/png"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                                    onchange="previewPhoto(event)">
                            </div>
                            <p class="mt-2 text-xs text-gray-500">Format: JPG, JPEG, PNG. Maksimal 2MB</p>
                            @error('photo')
                                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-6">
                        <h4 class="text-md font-medium text-gray-900 mb-4">Data Pribadi</h4>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap *</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('name') border-red-500 bg-red-50 @enderror">
                                <p class="mt-1 text-xs text-gray-500">Hanya huruf dan spasi yang diperbolehkan</p>
                                @error('name')
                                    <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                                <input type="text" name="email" id="email" value="{{ old('email') }}"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('email') border-red-500 bg-red-50 @enderror">
                                @error('email')
                                    <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">Password *</label>
                                <input type="password" name="password" id="password"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('password') border-red-500 bg-red-50 @enderror">
                                @error('password')
                                    <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">No. Telepon</label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('phone') border-red-500 bg-red-50 @enderror">
                                @error('phone')
                                    <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Tanggal
                                    Lahir</label>
                                <input type="date" name="date_of_birth" id="date_of_birth"
                                    value="{{ old('date_of_birth') }}"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('date_of_birth') border-red-500 bg-red-50 @enderror">
                                @error('date_of_birth')
                                    <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="emergency_contact" class="block text-sm font-medium text-gray-700">Kontak
                                    Darurat</label>
                                <input type="text" name="emergency_contact" id="emergency_contact"
                                    value="{{ old('emergency_contact') }}"
                                    placeholder="Nama & No. HP (contoh: Ibu Siti - 08123456789)"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('emergency_contact') border-red-500 bg-red-50 @enderror">
                                @error('emergency_contact')
                                    <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6">
                            <label for="address" class="block text-sm font-medium text-gray-700">Alamat Asal</label>
                            <textarea name="address" id="address" rows="2"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('address') border-red-500 bg-red-50 @enderror">{{ old('address') }}</textarea>
                            @error('address')
                                <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-6">
                        <h4 class="text-md font-medium text-gray-900 mb-4">Informasi Kos</h4>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label for="room_number" class="block text-sm font-medium text-gray-700">Nomor Kamar
                                    *</label>
                                <select name="room_number" id="room_number"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('room_number') border-red-500 bg-red-50 @enderror">
                                    <option value="">-- Pilih Kamar Tersedia --</option>
                                    @foreach($availableRooms as $room)
                                        <option value="{{ $room->room_number }}" {{ old('room_number') == $room->room_number ? 'selected' : '' }} data-price="{{ $room->price }}">
                                            Kamar {{ $room->room_number }} - Rp {{ number_format($room->price, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                                <p class="mt-1 text-xs text-gray-500">Pilih dari daftar kamar yang kosong</p>
                                @error('room_number')
                                    <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="monthly_rent" class="block text-sm font-medium text-gray-700">Sewa Bulanan (Rp) *</label>
                                <input type="number" name="monthly_rent" id="monthly_rent" value="{{ old('monthly_rent') }}"
                                    readonly
                                    class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md bg-gray-100 cursor-not-allowed font-semibold text-gray-500 @error('monthly_rent') border-red-500 bg-red-50 @enderror">
                                <p class="mt-1 text-xs text-gray-500">Harga sewa bulanan otomatis ditentukan oleh harga kamar yang dipilih.</p>
                                @error('monthly_rent')
                                    <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700">Deskripsi Tambahan</label>
                            <textarea name="notes" id="notes" rows="3"
                                placeholder="Catatan tambahan tentang penghuni (opsional)"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('notes') border-red-500 bg-red-50 @enderror">{{ old('notes') }}</textarea>
                            <p class="mt-1 text-xs text-gray-500">Informasi tambahan seperti pekerjaan, asal instansi, atau
                                catatan khusus lainnya</p>
                            @error('notes')
                                <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.users') }}"
                            class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Batal
                        </a>
                        <button type="submit"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Simpan Data Penghuni
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            10%,
            30%,
            50%,
            70%,
            90% {
                transform: translateX(-5px);
            }

            20%,
            40%,
            60%,
            80% {
                transform: translateX(5px);
            }
        }

        .animate-shake {
            animation: shake 0.5s ease-in-out;
        }
    </style>

    <script>
        function previewPhoto(event) {
            const preview = document.getElementById('photo-preview');
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.innerHTML = '<img src="' + e.target.result + '" class="h-full w-full object-cover" />';
                }
                reader.readAsDataURL(file);
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('userForm');
            const nameInput = document.getElementById('name');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const phoneInput = document.getElementById('phone');
            const dateOfBirthInput = document.getElementById('date_of_birth');
            const emergencyContactInput = document.getElementById('emergency_contact');
            const addressInput = document.getElementById('address');
            const roomNumberInput = document.getElementById('room_number');
            const monthlyRentInput = document.getElementById('monthly_rent');
            const jsErrorAlert = document.getElementById('jsErrorAlert');
            const jsErrorList = document.getElementById('jsErrorList');

            function validateEmail(email) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(email);
            }

            function validatePhone(phone) {
                const phoneRegex = /^(\+62|0)[0-9]{9,12}$/;
                return phoneRegex.test(phone.replace(/\s/g, ''));
            }

            // Fungsi untuk validasi nama (hanya huruf dan spasi)
            function validateName(name) {
                const nameRegex = /^[a-zA-Z\s]+$/;
                return nameRegex.test(name);
            }

            function showJsError(errors) {
                jsErrorList.innerHTML = '';
                errors.forEach(error => {
                    const li = document.createElement('li');
                    li.className = 'flex items-start gap-2';
                    li.innerHTML = '<span class="text-red-600 font-bold mt-0.5">•</span><span>' + error + '</span>';
                    jsErrorList.appendChild(li);
                });

                jsErrorAlert.classList.remove('hidden');
                jsErrorAlert.classList.remove('animate-shake');
                void jsErrorAlert.offsetWidth;
                jsErrorAlert.classList.add('animate-shake');
                jsErrorAlert.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }

            function hideJsError() {
                jsErrorAlert.classList.add('hidden');
            }

            function removeInputError(input) {
                input.classList.remove('border-red-500', 'bg-red-50');
            }

            function addInputError(input) {
                input.classList.add('border-red-500', 'bg-red-50');
            }

            // Event listeners untuk menghilangkan error saat user mengetik
            [nameInput, emailInput, passwordInput, phoneInput, dateOfBirthInput, emergencyContactInput, addressInput, roomNumberInput, monthlyRentInput].forEach(input => {
                input.addEventListener('input', function () {
                    hideJsError();
                    removeInputError(input);
                });
            });

            // Auto-fill monthly rent based on selected room
            roomNumberInput.addEventListener('change', function () {
                const selectedOption = this.options[this.selectedIndex];
                if (selectedOption && selectedOption.dataset.price) {
                    monthlyRentInput.value = selectedOption.dataset.price;
                    // Also hide error since it was just changed
                    hideJsError();
                    removeInputError(monthlyRentInput);
                }
            });

            form.addEventListener('submit', function (e) {
                const name = nameInput.value.trim();
                const email = emailInput.value.trim();
                const password = passwordInput.value.trim();
                const phone = phoneInput.value.trim();
                const roomNumber = roomNumberInput.value.trim();
                const monthlyRent = monthlyRentInput.value.trim();
                const errors = [];

                // Reset error styles
                [nameInput, emailInput, passwordInput, phoneInput, roomNumberInput, monthlyRentInput].forEach(input => {
                    removeInputError(input);
                });
                hideJsError();

                // Validasi nama
                if (name === '') {
                    errors.push('Nama lengkap tidak boleh kosong!');
                    addInputError(nameInput);
                } else if (name.length < 3) {
                    errors.push('Nama lengkap minimal 3 karakter!');
                    addInputError(nameInput);
                } else if (!validateName(name)) {
                    errors.push('Nama lengkap hanya boleh berisi huruf dan spasi!');
                    addInputError(nameInput);
                }

                // Validasi email
                if (email === '') {
                    errors.push('Email tidak boleh kosong!');
                    addInputError(emailInput);
                } else if (!validateEmail(email)) {
                    errors.push('Format email tidak valid! Contoh: user@example.com');
                    addInputError(emailInput);
                }

                // Validasi password
                if (password === '') {
                    errors.push('Password tidak boleh kosong!');
                    addInputError(passwordInput);
                } else if (password.length < 8) {
                    errors.push('Password minimal 8 karakter!');
                    addInputError(passwordInput);
                }

                // Validasi nomor kamar
                if (roomNumber === '') {
                    errors.push('Anda belum memilih kamar!');
                    addInputError(roomNumberInput);
                }

                // Validasi sewa bulanan
                if (monthlyRent === '') {
                    errors.push('Sewa bulanan tidak boleh kosong!');
                    addInputError(monthlyRentInput);
                } else if (parseFloat(monthlyRent) < 1000) {
                    errors.push('Sewa bulanan minimal Rp 1.000!');
                    addInputError(monthlyRentInput);
                }

                // Validasi nomor telepon (jika diisi)
                if (phone !== '' && !validatePhone(phone)) {
                    errors.push('Format nomor telepon tidak valid! Gunakan format: 08xx atau +62xx');
                    addInputError(phoneInput);
                }

                if (errors.length > 0) {
                    e.preventDefault();
                    showJsError(errors);
                    return false;
                }
            });
        });
    </script>
@endsection