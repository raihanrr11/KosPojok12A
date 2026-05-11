<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisteredUserControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_register_successfully()
    {
        Event::fake();

        $response = $this->post('/register', [
            'name' => 'Raihan',
            'email' => 'raihan@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/dashboard'); // RouteServiceProvider::HOME

        $this->assertDatabaseHas('users', [
            'email' => 'raihan@example.com'
        ]);

        Event::assertDispatched(Registered::class);

        $this->assertAuthenticated();
    }

    /** @test */
    public function registration_fails_when_name_is_missing()
    {
        $response = $this->post('/register', [
            'name' => '',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('name');
        $this->assertGuest();
    }

    /** @test */
    public function registration_fails_with_invalid_email()
    {
        $response = $this->post('/register', [
            'name' => 'User Testing',
            'email' => 'salahformatemail',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /** @test */
public function registration_fails_when_email_already_taken()
{
    User::factory()->create([
        'email' => 'raihan@example.com',
        'password' => Hash::make('password123'), // Tambahkan ini
    ]);

    $response = $this->post('/register', [
        'name' => 'Raihan',
        'email' => 'raihan@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertSessionHasErrors('email');
    $this->assertEquals(1, User::count());
}

    /** @test */
    public function registration_fails_when_password_confirmation_not_match()
    {
        $response = $this->post('/register', [
            'name' => 'Raihan',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'beda123',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertGuest();
    }
}
