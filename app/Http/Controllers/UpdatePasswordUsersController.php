<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UpdatePasswordUsersController extends Controller
{
    public function edit()
    {
        return view('pages.edit-password');
    }

    public function update(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'min:5', 'confirmed'],

        ]);

        if (Hash::check($request->current_password, Auth::guard('customer')->user()->password)) {
            Auth::guard('customer')->user()->update(['password' => Hash::make($request->password)]);
            return redirect()->route('dashboard');
        }
        throw ValidationException::withMessages([
            'current_password' => 'kata sandi Anda saat ini tidak cocok',
        ]);
    }
}
