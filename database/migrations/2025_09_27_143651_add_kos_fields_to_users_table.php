<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['admin', 'user'])
                      ->default('user')
                      ->after('email_verified_at');
            }

            if (!Schema::hasColumn('users', 'address')) {
                $table->text('address')->nullable()->after('phone');
            }

            if (!Schema::hasColumn('users', 'room_number')) {
                $table->string('room_number')->nullable()->after('address');
            }

            if (!Schema::hasColumn('users', 'monthly_rent')) {
                $table->decimal('monthly_rent', 10, 2)->nullable()->after('room_number');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
            if (Schema::hasColumn('users', 'address')) {
                $table->dropColumn('address');
            }
            if (Schema::hasColumn('users', 'room_number')) {
                $table->dropColumn('room_number');
            }
            if (Schema::hasColumn('users', 'monthly_rent')) {
                $table->dropColumn('monthly_rent');
            }
        });
    }
};
