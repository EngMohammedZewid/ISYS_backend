<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth/login');
    }

    public function login(Request $request)
    {
        $credentials = [
            'username' => $request->input('username'),
            'password' => $request->input('password')
        ];

        if (auth('employee')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('qrcode');
        }

        return redirect()->route('login-web')->with('error', 'Invalid credentials');
    }
}
