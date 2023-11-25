<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login', [
            'title' => 'Login',
        ]);
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'alpha_num', 'min:3', 'max:25'],
            'password' => ['required', 'min:6'],
        ]);

        if (Auth::attempt($credentials)) {
            return redirect('/')->with('message', 'Login berhasil');
        }

        throw ValidationException::withMessages([
            'username' => 'Username atau password tidak cocok!',
        ]);
    }
}
