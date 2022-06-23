<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DetailController extends Controller
{
    //
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request, $id)
    {
        $product = Product::with(['galleries'])->where('slug', $id)->firstOrFail();


        return view('pages.detail', [
            'product' => $product
        ]);
    }

    public function add(Request $request)
    {
        $product_id = $request->input('product_id');
        $product_qty = $request->input('product_qty');

        if (Auth::guard('customer')->check()) {
            $product_check = Product::where('id', $product_id)->first();
            if ($product_check) {
                if (Cart::where('products_id', $product_id)->where('customers_id', Auth::guard('customer')->user()->id)->exists()) {
                    return response()->json(['status' => $product_check->name . ' Sudah Ditambahkan ke keranjang']);
                } else {
                    # code...
                    $cart_item = new Cart();
                    $cart_item->products_id = $product_id;
                    $cart_item->customers_id = Auth::guard('customer')->user()->id;
                    $cart_item->qty = $product_qty;
                    $cart_item->price = $product_check->price;
                    $cart_item->save();

                    return response()->json(['status' => $product_check->name . ' Ditambahkan ke keranjang']);
                }
            } else {
                # code...
            }
        } else {
            return response()->json(['status' => "Masuk untuk melanjutkan"]);
        }
    }
}
