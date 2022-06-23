<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductGallery;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Admin\ProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Product::with(['category']);

            return Datatables::of($query)
                ->addColumn('action', function ($item) {
                    $button = '<div class="d-flex justify-content-center">
                                <div class="mt-2">
                                <a class="btn btn-primary" href="' . route('products.edit', $item->id) . '"> Sunting</a>
                                </div>
                                <div class="ml-2">
                               <form action="' . route('products.destroy', $item->id) . '" method="POST">
                                        '  . csrf_field() . '
                                        <input name="_method" type="hidden" value="DELETE">
                                        <button type="submit"  class="btn btn-xs btn-danger btn-flat show_confirm mt-2" data-toggle="tooltip" Onclick="return ConfirmDelete();">
                                            <i class="fas fa-trash"></i> 
                                        </button>
                                    </form>
                                </div>
                            </div>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make();
        }
        return view('pages.admin.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        $categories = Category::all();
        return view('pages.admin.product.create', [
            'users' => $users,
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'categories_id' => 'required|exists:categories,id',
            'price' => 'required|integer',
            'description' => 'required',
            'photos' => 'mimes:jpeg,jpg,png|max:2048',
        ], [
            'name.required' => 'Kolom Produk tidak boleh kosong',
            'name.max' => 'Kolom Nama tidak boleh lebih dari 255 karakter',
            'categories_id.required' => 'Kolom kategori tidak boleh kosong',
            'price.required' => 'Kolom harga tidak boleh kosong',
            'description.required' => 'Kolom deskripsi tidak boleh kosong',
            'photos.mimes' => 'Format Foto yang diperbolehkan hanya jpeg, jpg, png',
            'photos.max' => 'Ukuran Foto tidak boleh lebih dari 2MB',
        ]);
        $length = 6;
        $random = '';
        for ($i = 0; $i < $length; $i++) {
            $random .= rand(0, 1) ? rand(0, 9) : chr(rand(
                ord('a'),
                ord('z')
            ));
        }
        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $data['code'] = 'PRDT-' . Str::upper($random);
        $product = Product::create($data);

        $gallery = [
            'products_id' => $product->id,
            'photos' => $request->file('photos')->store('assets/product', 'public')
        ];
        ProductGallery::create($gallery);

        return redirect()->route('products.index')->withToastSuccess('Data Berhasil Disimpan!');
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
        $item = Product::findOrFail($id);
        $categories = Category::all();
        return view('pages.admin.product.edit', [
            'item' => $item,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        $data = $request->all();

        $item = Product::findOrFail($id);

        $data['slug'] = Str::slug($request->name);

        $item->update($data);

        return redirect()->route('products.index')->with('toast_info', 'Data berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Product::findOrFail($id);
        $item->delete();

        ProductGallery::where('products_id', $id)->delete();

        return redirect()->route('products.index')->withSuccess('Data Berhasil Dihapus!');
    }

    public function uploadGallery(Request $request)
    {
        $request->validate([
            'photos' => 'mimes:jpeg,jpg,png|max:2048',
        ], [
            'photos.mimes' => 'Format Foto yang diperbolehkan hanya jpeg, jpg, png',
            'photos.max' => 'Ukuran Foto tidak boleh lebih dari 2MB',
        ]);
        $data = $request->all();
        $data['photos'] = $request->file('photos')->store('assets/product', 'public');
        ProductGallery::create($data);

        return redirect()->route('products.edit', $request->products_id);
    }

    public function deleteGallery(Request $request, $id)
    {
        $item = ProductGallery::findOrFail($id);
        $item->delete();
        return redirect()->route('products.edit', $item->products_id);
    }


    public function reports(Request $request)
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

                    $return = '<ul>' . $li . '</ul>';
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

        return view('pages.admin.product.reports');
    }
}
