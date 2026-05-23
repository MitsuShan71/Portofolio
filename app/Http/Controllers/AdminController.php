<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($request->username === 'Admin' && $request->password === 'Admin#12345') {
            session(['admin_logged_in' => true]);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['login' => 'Invalid credentials.'])->onlyInput('username');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('admin_logged_in');
        return redirect()->route('admin.login');
    }
}
