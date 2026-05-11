<?php

// database/migrations/xxxx_add_public_to_complaints_table.php
// Jalankan: php artisan make:migration add_public_to_complaints_table --table=complaints

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->boolean('is_public')->default(false)->after('status');
            $table->boolean('allow_public_response')->default(false)->after('is_public');
        });
    }

    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->dropColumn(['is_public', 'allow_public_response']);
        });
    }
};