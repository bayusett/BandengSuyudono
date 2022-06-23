<?php

namespace App\Http\Controllers\Pemilik;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class PemesananPemilikController extends Controller
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
        return view('pages.pemilik.report.pemesanan.index');
    }

    public function GetData()
    {
        if (request()->ajax()) {
            $query = Transaction::all();

            return Datatables::of($query)
                ->addColumn('action', function ($item) {
                    $button = '<div class="d-flex justify-content-center">
                                <div class="mt-2">
                                <a class="btn btn-primary" href="' . route('pemilik-orders-show', $item->id) . '">Sunting</a>
                                </div>
                            </div>';
                    return $button;
                })
                ->editColumn('created_at', function ($item) {
                    return $item->created_at->format('d M Y');
                })
                ->editColumn('payment_status', function ($item) {
                    if ($item->payment_status == 'PENDING') {
                        return '<span class="badge badge-pill badge-warning">Pending</span>';
                    } elseif ($item->payment_status == 'CONFIRM') {
                        return '<span class="badge badge-pill badge-primary">Confirm</span>';
                    } else {
                        return '<span class"badge badge-pill badge-danger">Dibatalkan</span>';
                    }
                })
                ->rawColumns(['action', 'created_at', 'payment_status'])
                ->addIndexColumn()
                ->make();
        }

        return view('pages.pemilik.pemesanan.index');
    }

    public function show($id)
    {
        $item = Transaction::with(['customer'])->findOrFail($id);
        $oders = TransactionDetail::where('transactions_id', $id)->first();
        return view('pages.pemilik.pemesanan.edit', [
            'item' => $item,
            'oders' => $oders,
        ]);
    }
}
