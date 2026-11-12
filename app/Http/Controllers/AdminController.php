<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class AdminController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $rateLimitKey = 'login:'.($request->ip() ?? 'unknown');

        if (RateLimiter::tooManyAttempts($rateLimitKey, 5)) {
            $seconds = RateLimiter::availableIn($rateLimitKey);

            return back()->withErrors([
                'login' => "Too many login attempts. Please try again in {$seconds} seconds.",
            ])->onlyInput('username');
        }

        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $username = config('admin.username');
        $password = config('admin.password');

        if (! $username || ! $password) {
            return back()->withErrors([
                'login' => 'Admin credentials are not configured. Please set ADMIN_USERNAME and ADMIN_PASSWORD in your .env file.',
            ])->onlyInput('username');
        }

        if ($request->username === $username && $request->password === $password) {
            RateLimiter::clear($rateLimitKey);

            $request->session()->regenerate();
            session(['admin_logged_in' => true]);

            return redirect()->route('admin.dashboard');
        }

        RateLimiter::hit($rateLimitKey, 60);

        return back()->withErrors(['login' => 'Invalid credentials.'])->onlyInput('username');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('admin_logged_in');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
