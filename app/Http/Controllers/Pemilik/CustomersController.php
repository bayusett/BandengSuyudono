<?php

namespace App\Http\Controllers\Pemilik;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class CustomersController extends Controller
{
    public function index(Request $request)
    {
        $form_date = $request->from_date;
        $to_date = $request->to_date;
        if (request()->ajax()) {
            if (!empty($form_date)) {
                $query = Customer::whereBetween('created_at', [$form_date, $to_date])->get();
            } else {
                $query = Customer::with(['province', 'regency']);
            }
            return Datatables::of($query)
                ->addColumn('created', function ($item) {
                    return date('Y-m-d', strtotime($item->created_at));
                })
                ->addColumn('provinces', function ($item) {
                    $provinsi = $item->provinces_id ? $item->province->name : '-';
                    return $provinsi;
                })
                ->addColumn('regencies', function ($item) {
                    $regency = $item->regencies_id ? $item->regency->name : '-';
                    return $regency;
                })
                ->addColumn('address', function ($item) {
                    $address = $item->address ? $item->address : '-';
                    return $address;
                })
                ->rawColumns(['created', 'provinces', 'regencies', 'address'])
                ->addIndexColumn()
                ->make();
        }

        return view('pages.pemilik.customer.reports');
    }

    public function GetData()
    {
        if (request()->ajax()) {
            $query = Customer::query();

            return Datatables::of($query)
                ->editColumn('created_at', function ($item) {
                    return date('d F Y', strtotime($item->created_at));
                })
                ->rawColumns(['created_at'])
                ->addIndexColumn()
                ->make();
        }

        return view('pages.pemilik.customer.index');
    }
}
