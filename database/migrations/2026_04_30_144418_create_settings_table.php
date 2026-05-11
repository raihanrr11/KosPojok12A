<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Seed default dorm info
        $defaults = [
            ['key' => 'dorm_name',           'value' => 'Kos Management'],
            ['key' => 'dorm_address',         'value' => null],
            ['key' => 'dorm_city',            'value' => null],
            ['key' => 'dorm_phone',           'value' => null],
            ['key' => 'dorm_email',           'value' => null],
            ['key' => 'dorm_whatsapp',        'value' => null],
            ['key' => 'dorm_bank_name',       'value' => null],
            ['key' => 'dorm_bank_account_no', 'value' => null],
            ['key' => 'dorm_bank_account_name','value' => null],
            ['key' => 'dorm_description',     'value' => null],
            ['key' => 'dorm_open_hours',      'value' => null],
        ];

        foreach ($defaults as $row) {
            DB::table('settings')->insert(array_merge($row, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
