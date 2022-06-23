<?php

namespace App\Http\Controllers\Pemilik;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class PemilikUserController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = User::query();

            return Datatables::of($query)
                ->editColumn('created_at', function ($item) {
                    return date('d F Y', strtotime($item->created_at));
                })
                ->rawColumns(['created_at'])
                ->addIndexColumn()
                ->make();
        }
        return view('pages.pemilik.user.index');
    }
}
