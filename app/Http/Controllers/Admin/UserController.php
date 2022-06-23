<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = User::query();

            return Datatables::of($query)
                ->addColumn('action', function ($item) {
                    $button = '<div class="d-flex justify-content-center">
                                <div class="mt-2">
                                <a class="btn btn-primary" href="' . route('users.edit', $item->id) . '"> Sunting</a>
                                </div>
                                <div class="ml-2">
                               <form action="' . route('users.destroy', $item->id) . '" method="POST">
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
                ->editColumn('created_at', function ($item) {
                    return date('d F Y', strtotime($item->created_at));
                })
                ->rawColumns(['action', 'created_at'])
                ->addIndexColumn()
                ->make();
        }
        return view('pages.admin.user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.user.create');
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
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5',
            'roles' => 'nullable|string|in:ADMIN,PEMILIK',
        ], [
            'name.required' => 'Kolom Nama tidak boleh kosong',
            'name.max' => 'Kolom Nama maximal 50 karakter',
            'email.required' => 'Kolom email tidak boleh kosong',
            'email.unique' => 'Alamat Email sudah terdaftar',
            'password.required' => 'Kolom Password tidak boleh kosong',
            'password.min' => 'Password minimal 5 karakter',
        ]);
        $length = 5;
        $random = '';
        for ($i = 0; $i < $length; $i++) {
            $random .= rand(0, 1) ? rand(0, 9) : chr(rand(
                ord('a'),
                ord('z')
            ));
        }
        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $data['code'] = 'USR-' . Str::upper($random);
        User::create($data);

        return back()->withToastSuccess('Data Berhasil Disimpan!');;
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
        $item = User::findOrFail($id);

        return view('pages.admin.user.edit', [
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
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'roles' => 'nullable|string|in:ADMIN,PEMILIK',
        ]);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        } else {
            unset($user->password);
        }
        $user->roles = $request->roles;
        $user->update();
        return redirect()->route('users.index')->with('toast_info', 'Data berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = User::findOrFail($id);
        $item->delete();

        return redirect()->route('users.index')->withSuccess('Data Berhasil Dihapus!');
    }
}
