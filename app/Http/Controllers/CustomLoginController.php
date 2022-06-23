<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomLoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function proseslogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        // dd($credentials);
        if (Auth::guard('customer')->attempt($credentials)) {
            return redirect()->intended('/')->with('toast_success', 'Login Berhasil');
        } else {
            alert()->error('Gagal', 'Login gagal');
            return redirect()->back();
        }
    }

    public function register()
    {
        return view('auth.register');
    }

    public function customregister(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => 'required|email|unique:customers',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $length = 5;
        $random = '';
        for ($i = 0; $i < $length; $i++) {
            $random .= rand(0, 1) ? rand(0, 9) : chr(rand(
                ord('a'),
                ord('z')
            ));
        }
        $data = $request->all();
        $data['code'] = 'CST-' . Str::upper($random);
        $check = $this->create($data);
        return redirect()->route('register-success');
    }

    public function create(array $data)
    {
        $length = 5;
        $random = '';
        for ($i = 0; $i < $length; $i++) {
            $random .= rand(0, 1) ? rand(0, 9) : chr(rand(
                ord('a'),
                ord('z')
            ));
        }

        $rdm = 'CST-' . Str::upper($random);
        return Customer::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'code' => $rdm,
            'password' => Hash::make($data['password'])
        ]);
    }

    public function signout(Request $request)
    {
        $request->session()->flush();
        Auth::guard('customer')->logout();

        return redirect()->route('home');
    }


    public function check(Request $request)
    {
        return Customer::where('email', $request->email)->count() > 0 ? 'Unavailable' : "Available";
    }

    public function success()
    {
        return view('auth.success');
    }

    public function admins()
    {
        return view('auth.login_admin');
    }
}
