<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // dd(Request('key'));
        $categories = Category::take(6)->get();
        $products = Product::with(['galleries'])->filter(request(['key']))->take(8)->latest()->get();

        return view('pages.home', [
            'categories' => $categories,
            'products' => $products,
        ]);
    }

    public function success()
    {
        return view('auth.success');
    }
}
