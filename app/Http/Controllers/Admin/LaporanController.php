<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
                    if (empty($item->product->name)) {
                        return 'produk tidak ada';
                    } else {
                        return $item->product->name;
                    }
                })
                ->addColumn('price_product', function ($item) {
                    return $item->product->price;
                })
                ->addColumn('created_at', function ($item) {
                    return date('Y-m-d', strtotime($item->created_at));
                })
                ->addColumn('price', function ($item) {
                    return $item->product->price * $item->qty;
                })
                ->rawColumns(['products', 'customers', 'created_at', 'payments', 'status_pembayaran', 'price'])
                ->make(true);
            # code...
        }
        return view('pages.admin.report.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function pdfcreate()
    {
        return view('pages.admin.report.cetak');
    }

    public function allreport()
    {
        $data = TransactionDetail::with(['transaction']);
        return view('pages.laporanpdf', compact('data'));
    }
}
