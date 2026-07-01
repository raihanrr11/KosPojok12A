<?php

// app/Http/Controllers/Auth/AuthenticatedSessionController.php
// Replace seluruh isi file dengan ini:

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        $availableRooms = \App\Models\Room::where('status', 'available')->get();
        return view('auth.login', compact('availableRooms'));
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();
        $user = Auth::user();
        \Log::info('User logged in', [
            'id' => $user->id,
            'email' => $user->email,
            'role' => $user->role ?? 'no_role'
        ]);
        // Check role and redirect — do NOT use intended() here,
        // as a cached intended URL could send an admin to a user route.
        if (isset($user->role)) {
            if ($user->role === 'admin') {
                \Log::info('Redirecting to admin dashboard');
                return redirect()->route('admin.dashboard');
            }
            if ($user->role === 'user') {
                \Log::info('Redirecting to user dashboard');
                return redirect()->route('user.dashboard');
            }
        }
        // Fallback redirect
        \Log::info('Fallback redirect to home');
        return redirect(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}