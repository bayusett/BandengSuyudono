<?php

namespace App\Http\Controllers\Pemilik;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        $form_date = $request->from_date;
        $to_date = $request->to_date;

        if (request()->ajax()) {
            if (!empty($form_date)) {
                $data = Product::whereBetween('created_at', [$form_date, $to_date])->get();
            } else {
                $data = Product::with(['category']);
            }
            return DataTables::of($data)
                ->addColumn('gallery', function ($item) {
                    $li = '';
                    foreach ($item->galleries()->get() as $gallery) {
                        $li .= '<li><img src="' . Storage::url($gallery->photos) . '" style="max-height:50px"></li>';
                    }

                    $return = '<ul>' . $li . '</ul>' ?? '-';
                    return $return;
                })
                ->addColumn('created_at', function ($item) {
                    return date('Y-m-d', strtotime($item->created_at));
                })
                ->addColumn('category', function ($item) {
                    return $item->category->name;
                })
                ->rawColumns(['gallery', 'created_at', 'category'])
                ->make(true);
        }

        return view('pages.pemilik.product.reports');
    }

    public function GetData()
    {
        if (request()->ajax()) {
            $query = Product::with(['category']);

            return Datatables::of($query)
                ->addColumn('created_at', function ($item) {
                    return date('Y-m-d', strtotime($item->created_at));
                })
                ->rawColumns(['created_at'])
                ->addIndexColumn()
                ->make();
        }

        return view('pages.pemilik.product.index');
    }
}
