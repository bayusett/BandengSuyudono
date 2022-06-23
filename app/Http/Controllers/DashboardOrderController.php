<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardOrderController extends Controller
{
    public function index()
    {
        $order = Transaction::where('customers_id', Auth::guard('customer')->user()->id)->latest()->get();
        return view('pages.my-order', compact('order'));
    }

    public function edit($id)
    {
        $item = Transaction::with(['customer'])->findOrFail($id);
        $order = TransactionDetail::where('transactions_id', $id)->first();
        return view('pages.dashboard-detail-order', [
            'item' => $item,
            'order' => $order,
        ]);
    }

    public function update(Request $request, $id)
    {
        $item = Transaction::where('id', $id)
            ->update([
                'transaction_status' => 'SUCCESS'
            ]);
        return redirect()->route('users.order');
    }
}
