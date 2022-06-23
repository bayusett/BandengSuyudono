<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // $customer = User::count();
        return view('pages.dashboard');
    }
}
