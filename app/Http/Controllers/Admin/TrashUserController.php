<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class TrashUserController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = User::onlyTrashed()->get();

            return Datatables::of($query)
                ->addColumn('action', function ($item) {
                    $button = '<div class="d-flex justify-content">
                                <div class="mt-2">
                                <a class="btn btn-primary" href="' . route('trash.restore.user', $item->id) . '"> <i class="fas fa-refresh"></i></a>
                                </div>
                                <div class="ml-2">
                               <form action="' . route('trash.deletes.user', $item->id) . '" method="POST">
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
                ->editColumn('created_at', function ($item) {
                    return date('d F Y', strtotime($item->created_at));
                })
                ->rawColumns(['action', 'created_at'])
                ->addIndexColumn()
                ->make();
        }

        return view('pages.admin.user.trash');
    }

    public function restore($id = null)
    {
        if ($id != null) {
            User::onlyTrashed()
                ->where('id', $id)
                ->restore();
        } else {
            User::onlyTrashed()->restore();
        }

        return redirect()->route('trash.user')->withSuccess('Data Berhasil Dikembalikan!');
    }

    public function deletepermanent($id = null)
    {
        if ($id != null) {
            User::onlyTrashed()
                ->where('id', $id)
                ->forceDelete();
        } else {
            User::onlyTrashed()->forceDelete();
        }

        return redirect()->route('trash.user')->withSuccess('Data Berhasil Dihapus Permanent!');
    }
}
