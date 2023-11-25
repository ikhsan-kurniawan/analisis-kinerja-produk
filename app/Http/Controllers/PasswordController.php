<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class PasswordController extends Controller
{
    public function edit()
    {
        return view('users.edit-password', [
            'title' => 'Edit Password',
            'header' => 'Edit Password',
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'password_sekarang' => ['required'],
            'password' => ['required', 'min:6', 'confirmed'],
        ]);

        if (!Hash::check($request->password_sekarang, auth()->user()->password)) {
            throw ValidationException::withMessages([
                'password_sekarang' => 'Password tidak cocok',
            ]);
        }

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profil.edit')->with('message', 'Password berhasil diubah');
    }
}
