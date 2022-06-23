<?php

namespace App\Http\Controllers\Pemilik;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UpdatePasswordPemilikController extends Controller
{
    public function edit()
    {
        return view('pages.pemilik.password.edit');
    }

    public function update(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'min:5', 'confirmed'],

        ], [
            'current_password.required' => 'Kolom Current Password Tidak Boleh Kosong',
            'password.required' => 'Kolom Password Baru tidak Boleh Kosong',
            'password.min' => 'Password Harus minimal 5 karakter',
            'password.confirmed' => 'Konfirmasi Password tidak sesuai',
        ]);

        if (Hash::check($request->current_password, auth()->user()->password)) {
            auth()->user()->update(['password' => Hash::make($request->password)]);
            return redirect()->route('pemilik-dashboard');
        }
        throw ValidationException::withMessages([
            'current_password' => 'kata sandi Anda saat ini tidak cocok',
        ]);
    }
}
