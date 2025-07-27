<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return inertia('staff/Login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::guard('staff')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('staff.dashboard'));
        }

        return back()->withErrors(['username' => 'Invalid credentials'])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::guard('staff')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/staff/login');
    }

}
