<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus admin lama jika ada
        User::where('email', 'admin@kos.com')->delete();

        // Buat admin baru
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@kos.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'), // Ganti password sesuai keinginan
            'role' => 'admin',
        ]);

        echo "Admin berhasil dibuat!\n";
        echo "Email: admin@kos.com\n";
        echo "Password: admin123\n";
    }
}