<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PemesananController extends Controller
{
    public function index(Request $request)
    {
        $pemesanan = $request->pemesanan;
        if (request()->ajax()) {
            if (!empty($pemesanan)) {
                $data = Transaction::where('payment_status', $pemesanan)->get();
            } else {
                $data = Transaction::with(['customer'])->get();
            }
            return DataTables::of($data)
                ->addColumn('products', function ($item) {
                    $li = '';
                    foreach ($item->TransactionDetails()->get() as $produk) {
                        $li .= '<li>' . $produk->product->name . ' </li>';
                    }

                    $return = '<ul>' . $li . '</ul>';
                    return $return;
                })
                ->addColumn('customers', function ($item) {
                    return $item->customer->name;
                })
                ->addColumn('created_at', function ($item) {
                    return date('Y-m-d', strtotime($item->created_at));
                })
                ->addColumn('payments', function ($item) {
                    return $item->no_invoice;
                })
                ->addColumn('status_pembayaran', function ($item) {
                    return $item->payment_status;
                })
                ->addColumn('price', function ($item) {
                    return $item->total_price;
                })
                ->rawColumns(['products', 'customers', 'created_at', 'payments', 'status_pembayaran', 'price'])
                ->make(true);
        }
        return view('pages.admin.report.pemesanan.index');
    }

    public function pesanan()
    {
        return view('pages.admin.report.pemesanan.cetak');
    }
}
