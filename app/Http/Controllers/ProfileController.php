<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('users.edit', [
            'title' => 'Edit Profil',
            'header' => 'Edit Profil',
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'username' => ['min:3', 'max:25', 'alpha_num', 'required', 'unique:users,username,' . auth()->id()],
            'nama' => ['string', 'min:3', 'max:100', 'required'],
        ]);

        Auth::user()->update([
            'username' => $request->username,
            'nama' => $request->nama,
        ]);

        return back()->with('message', 'Profil berhasil diubah');
    }
}
