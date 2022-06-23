<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Regency;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::with(['product.galleries', 'customer'])
            ->where('customers_id', Auth::guard('customer')->user()->id)
            ->get();
        $provinces = Province::all();
        return view('pages.cart', [
            'carts' => $carts,
            'provinces' => $provinces,
        ]);
    }
    public function delete(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();

        return redirect()->route('detail-carts');
    }
    public function updatecart(Request $request)
    {
        $product_id = $request->input('product_id');
        $qty = $request->input('product_qty');

        if (Auth::guard('customer')->check()) {
            if (Cart::where('products_id', $product_id)->where('customers_id', Auth::guard('customer')->user()->id)->exists()) {
                $cart = Cart::where('products_id', $product_id)->where('customers_id', Auth::guard('customer')->user()->id)->first();
                $cart->qty = $qty;
                $cart->update();

                return response()->json(['status' => "Jumlah Berhasil di update"]);
            }
        }
    }

    public function cartcount()
    {
        $cartcount = Cart::where('customers_id', Auth::guard('customer')->user()->id)->count();
        return response()->json(['count' => $cartcount]);
    }

    public function success()
    {
        return view('pages.success');
    }
    public function unfinish()
    {
        return view('pages.unfinish');
    }
    public function failed()
    {
        return view('pages.failed');
    }
    public function getkabupaten(Request $request)
    {
        $idprovinsi = $request->idprovinsi;

        $regencies = Regency::where('province_id', $idprovinsi)->get();
        $option = '<option hidden>Choose Kabupaten</option>';
        foreach ($regencies as  $kabupaten) {
            $option .= '<option value= ' . $kabupaten->id . '>' . $kabupaten->name . '</option>';
        }

        echo $option;
    }
}
