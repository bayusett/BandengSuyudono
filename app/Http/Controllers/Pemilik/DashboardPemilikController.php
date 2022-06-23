<?php

namespace App\Http\Controllers\Pemilik;

use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardPemilikController extends Controller
{
    public function index()
    {
        $customer = Customer::count();
        $revenue = Transaction::sum('total_price');
        $transaction = Transaction::count();
        return view('pages.pemilik.dashboard', [
            'customer' => $customer,
            'revenue' => $revenue,
            'transaction' => $transaction
        ]);
    }
}
