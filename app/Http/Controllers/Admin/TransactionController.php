<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = Transaction::all();

            return Datatables::of($query)
                ->addColumn('action', function ($item) {
                    $button = '<div class="d-flex justify-content-center">
                                <div class="mt-2">
                                <a class="btn btn-primary" href="' . route('orders.edit', $item->id) . '"> Sunting</a>
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

        return view('pages.admin.payment.index');
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
        $item = Transaction::with(['customer'])->findOrFail($id);
        $oders = TransactionDetail::where('transactions_id', $id)->first();
        return view('pages.admin.payment.edit', [
            'item' => $item,
            'oders' => $oders,
        ]);
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
        $item = Transaction::findOrFail($id);
        $item->update($request->only(['payment_status', 'transaction_status']));
        return redirect()->back()->with('toast_info', 'Data berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Transaction::findOrFail($id);
        $item->delete();
        TransactionDetail::where('transactions_id', $id)->delete();

        return redirect()->route('orders.index')->withSuccess('Data Berhasil Dihapus!');
    }
}
