<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Admin\CategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Category::query();

            return Datatables::of($query)
                ->addColumn('action', function ($item) {
                    $button = '<div class="d-flex justify-content-center">
                                <div class="mt-2">
                                <a class="btn btn-primary" href="' . route('category.edit', $item->id) . '"> Sunting</a>
                                </div>
                                <div class="ml-2">
                                <form action="' . route('category.destroy', $item->id) . '" method="POST">
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
                ->editColumn('photo', function ($item) {
                    return $item->photo ? '<img src="' . Storage::url($item->photo) . '" style="max-height: 40px;"/>' : '';
                })
                ->rawColumns(['action', 'photo'])
                ->addIndexColumn()
                ->make();
        }
        return view('pages.admin.category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $data['photo'] = $request->file('photo')->store('assets/category', 'public');
        Category::create($data);
        return redirect()->route('category.index')->withToastSuccess('Data Berhasil Disimpan!');
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
        $item = Category::findOrFail($id);

        return view('pages.admin.category.edit', [
            'item' => $item
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        if (!$request->file('photo')) {
            $item = Category::findOrFail($id);
            $item->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
            ]);
        } else {
            $data = $request->all();
            $data['slug'] = Str::slug($request->name);
            $data['photo'] = $request->file('photo')->store('assets/category', 'public');
            $item = Category::findOrFail($id);
            $item->update($data);
        }
        return redirect()->route('category.index')->with('toast_info', 'Data berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Category::findOrFail($id);
        $item->delete();

        return redirect()->route('category.index')->withSuccess('Data Berhasil Dihapus!');
    }
}
