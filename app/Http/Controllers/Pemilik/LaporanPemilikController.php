<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LaporanPemilikController extends Controller
{
    public function index(Request $request)
    {
        $form_date = $request->from_date;
        $to_date = $request->to_date;

        if (request()->ajax()) {
            if (!empty($form_date)) {
                $data = TransactionDetail::whereBetween('created_at', [$form_date, $to_date])->get();
            } else {
                $data = TransactionDetail::with(['transaction', 'product']);
            }
            return DataTables::of($data)
                ->addColumn('products', function ($item) {
                    return $item->product->name ? $item->product->name : '-';
                })
                ->addColumn('created_at', function ($item) {
                    return date('Y-m-d', strtotime($item->created_at));
                })
                ->addColumn('payments', function ($item) {
                    return $item->transaction->no_invoice;
                })
                ->addColumn('status_pembayaran', function ($item) {
                    return $item->transaction->transaction_status;
                })
                ->addColumn('harga', function ($item) {
                    return $item->product->price;
                })
                ->addColumn('price', function ($item) {
                    return $item->product->price * $item->qty;
                })
                ->rawColumns(['products', 'customers', 'created_at', 'payments', 'status_pembayaran', 'harga', 'price'])
                ->make(true);
        }
        return view('pages.pemilik.report.index');
    }
}
