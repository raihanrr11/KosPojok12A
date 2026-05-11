<?php

namespace Tests\Unit;

use Tests\TestCase;
use Mockery;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;

class AuthenticatedSessionControllerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /** @test */
    public function login_redirects_admin_to_admin_dashboard()
    {
        // Mock LoginRequest
        $request = Mockery::mock(LoginRequest::class);
        $request->shouldReceive('authenticate')->once();
        $request->shouldReceive('session->regenerate')->once();

        // Mock session() helper
        $request->shouldReceive('session')->andReturnSelf();

        // Mock Auth::user()
        $user = (object)[
            'id' => 1,
            'email' => 'admin@mail.com',
            'role' => 'admin'
        ];
        Auth::shouldReceive('user')->once()->andReturn($user);

        $controller = new AuthenticatedSessionController();

        $response = $controller->store($request);

        // Assertion redirect ke admin.dashboard
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertStringContainsString(
            route('admin.dashboard'),
            $response->getTargetUrl()
        );
    }

    /** @test */
    public function login_redirects_user_to_user_dashboard()
    {
        $request = Mockery::mock(LoginRequest::class);
        $request->shouldReceive('authenticate')->once();
        $request->shouldReceive('session->regenerate')->once();
        $request->shouldReceive('session')->andReturnSelf();

        $user = (object)[
            'id' => 2,
            'email' => 'user@mail.com',
            'role' => 'user'
        ];
        Auth::shouldReceive('user')->once()->andReturn($user);

        $controller = new AuthenticatedSessionController();

        $response = $controller->store($request);

        $this->assertStringContainsString(
            route('user.dashboard'),
            $response->getTargetUrl()
        );
    }

    /** @test */
    public function login_without_role_redirects_to_home()
    {
        $request = Mockery::mock(LoginRequest::class);
        $request->shouldReceive('authenticate')->once();
        $request->shouldReceive('session->regenerate')->once();
        $request->shouldReceive('session')->andReturnSelf();

        $user = (object)[
            'id' => 3,
            'email' => 'norole@mail.com',
            'role' => null
        ];
        Auth::shouldReceive('user')->once()->andReturn($user);

        $controller = new AuthenticatedSessionController();

        $response = $controller->store($request);

        $this->assertStringContainsString(
            RouteServiceProvider::HOME,
            $response->getTargetUrl()
        );
    }

    /** @test */
    public function logout_should_invalidate_session_and_redirect_to_home()
    {
        $request = Mockery::mock(\Illuminate\Http\Request::class);

        // Mock session handling
        $request->shouldReceive('session->invalidate')->once();
        $request->shouldReceive('session->regenerateToken')->once();
        $request->shouldReceive('session')->andReturnSelf();

        // Mock logout
        Auth::shouldReceive('guard->logout')->once();

        $controller = new AuthenticatedSessionController();
        $response = $controller->destroy($request);

        $this->assertEquals(url('/'), $response->getTargetUrl());


    }
}
