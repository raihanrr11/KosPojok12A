<?php

// database/migrations/xxxx_add_photo_to_users_table.php
// Jalankan: php artisan make:migration add_photo_to_users_table --table=users

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('photo')->nullable()->after('email');
            $table->date('date_of_birth')->nullable()->after('room_number');
            $table->text('emergency_contact')->nullable()->after('date_of_birth');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['photo', 'date_of_birth', 'emergency_contact']);
        });
    }
};