<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class TrashCategoryController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = Category::onlyTrashed()->get();

            return Datatables::of($query)
                ->addColumn('action', function ($item) {
                    $button = '<div class="d-flex justify-content">
                                <div class="mt-2">
                              <a class="btn btn-primary" href="' . route('trash.restore', $item->id) . '"> <i class="fas fa-refresh"></i></a>
                                </div>
                                <div class="ml-2">
                              <form action="' . route('trash.deletes', $item->id) . '" method="POST">
                                        '  . csrf_field() . '
                                        <input name="_method" type="hidden" value="DELETE">
                                        <button type="submit"  class="btn btn-xs btn-danger btn-flat show_confirm mt-2" data-toggle="tooltip" Onclick="return ConfirmDelete();">
                                            <i class="fas fa-trash-restore"></i>
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

        return view('pages.admin.category.trash');
    }

    public function restore($id = null)
    {
        if ($id != null) {
            Category::onlyTrashed()
                ->where('id', $id)
                ->restore();
        } else {
            Category::onlyTrashed()->restore();
        }

        return redirect()->route('trash.category')->withSuccess('Data Berhasil Dikembalikan!');
    }

    public function deletepermanent($id = null)
    {
        if ($id != null) {
            Category::onlyTrashed()
                ->where('id', $id)
                ->forceDelete();
        } else {
            Category::onlyTrashed()->forceDelete();
        }

        return redirect()->route('trash.category')->withSuccess('Data Berhasil Dihapus Permanent!');
    }
}
