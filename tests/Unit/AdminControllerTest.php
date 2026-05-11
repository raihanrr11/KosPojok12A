<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Payment;
use App\Models\Complaint;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // Buat admin
        $this->admin = User::factory()->create(['role' => 'admin']);

        // Login sebagai admin
        $this->actingAs($this->admin);
    }

    /** @test */
    public function admin_can_view_dashboard()
    {
        $response = $this->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertViewIs('admin.dashboard');
        $response->assertViewHas('stats');
    }

    /** @test */
    public function admin_can_view_users_page()
    {
        User::factory()->count(5)->create(['role' => 'user']);

        $response = $this->get('/admin/users');

        $response->assertStatus(200);
        $response->assertViewIs('admin.users.index');
        $response->assertViewHas('users');
    }

   /** @test */
public function admin_can_store_new_user()
{
    // Tampilkan exception asli agar kita tahu penyebab 500
    $this->withoutExceptionHandling();

    Storage::fake('public');

    $file = UploadedFile::fake()->image('photo.jpg');

    // Jalankan request dan tangkap exception agar bisa kita lihat
    try {
        $response = $this->post('/admin/users', [
            'name' => 'User Baru',
            'email' => 'baru@example.com',
            'password' => 'password123',
            'phone' => '0812345678',
            'address' => 'Malang',
            'room_number' => 'A01',
            'monthly_rent' => 500000,
            'photo' => $file,
        ]);
    } catch (\Throwable $e) {
        // Cetak pesan & stack trace supaya kita tahu apa yang salah
        echo "\n\n---- EXCEPTION MESSAGE ----\n";
        echo $e->getMessage() . "\n\n";
        echo "---- STACK TRACE ----\n";
        echo $e->getTraceAsString() . "\n";
        // Gagalkan test supaya output terlihat oleh phpunit
        $this->fail('Exception thrown: ' . $e->getMessage());
    }

    // Jika tidak ada exception, lanjutkan assertion normal
    $response->assertRedirect(route('admin.users'));

    $this->assertDatabaseHas('users', [
        'email' => 'baru@example.com',
        'room_number' => 'A01'
    ]);
}

/** @test */
public function admin_can_update_user()
{
    $user = User::factory()->create([
        'role' => 'user',
        'room_number' => 'A01'
    ]);

    $response = $this->put("/admin/users/{$user->id}", [
        'name' => 'Updated Name',
        'email' => 'updated@example.com',
        'room_number' => 'A02',
        'monthly_rent' => 600000,
    ]);

    $response->assertRedirect('/admin/users');

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => 'Updated Name',
        'email' => 'updated@example.com',
    ]);
}

/** @test */
public function admin_can_delete_user()
{
    $user = User::factory()->create([
        'role' => 'user',
        'room_number' => 'A05'
    ]);

    $response = $this->delete("/admin/users/{$user->id}");

    $response->assertRedirect(route('admin.users'));


    $this->assertDatabaseMissing('users', [
        'id' => $user->id
    ]);
}
}
