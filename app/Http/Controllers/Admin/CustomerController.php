<?php

namespace App\Http\Controllers\Admin;

use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = Customer::query();

            return Datatables::of($query)
                ->addColumn('action', function ($item) {
                    $button = '<div class="d-flex justify-content-center">
                                <div class="mt-2">
                                <a class="btn btn-primary" href="' . route('kustomer.edit', $item->id) . '"> Sunting</a>
                                </div>
                                <div class="ml-2">
                               <form action="' . route('kustomer.destroy', $item->id) . '" method="POST">
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
        return view('pages.admin.customer.index');
    }

    public function create()
    {
        return view('pages.admin.customer.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:customers',
            'password' => 'required|min:5',
        ], [
            'name.required' => 'Kolom Nama tidak boleh kosong',
            'name.max' => 'Kolom Nama maximal 50 karakter',
            'email.required' => 'Kolom email tidak boleh kosong',
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
        $data['code'] = 'CST-' . Str::upper($random);
        Customer::create($data);

        return back()->with('success', 'Customer created successfully.');
    }

    public function edit($id)
    {
        $item = Customer::findOrFail($id);

        return view('pages.admin.customer.edit', [
            'item' => $item
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:customers,email,' . $id,
            'roles' => 'nullable|string|in:ADMIN,PEMILIK',
        ]);

        $item = Customer::findOrFail($id);
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        } else {
            unset($data['password']);
        }
        $item->update($data);
        return redirect()->route('kustomer.index')->with('toast_info', 'Data berhasil diupdate!');
    }

    public function destroy($id)
    {
        $item = Customer::findOrFail($id);
        $item->delete();

        return redirect()->route('kustomer.index')->withSuccess('Data Berhasil Dihapus!');
    }

    public function getdatacustomer(Request $request)
    {
        $form_date = $request->from_date;
        $to_date = $request->to_date;
        if (request()->ajax()) {
            if (!empty($form_date)) {
                $query = Customer::whereBetween('created_at', [$form_date, $to_date])->get();
            } else {
                $query = Customer::with(['province', 'regency']);
            }

            return Datatables::of($query)
                ->addColumn('created', function ($item) {
                    return $item->created_at->format('d M Y');
                })
                ->addColumn('provinces', function ($item) {
                    $provinsi = $item->provinces_id ? $item->province->name : '-';
                    return $provinsi;
                })
                ->addColumn('regencies', function ($item) {
                    $regency = $item->regencies_id ? $item->regency->name : '-';
                    return $regency;
                })
                ->addColumn('address', function ($item) {
                    $address = $item->address ? $item->address : '-';
                    return $address;
                })
                ->rawColumns(['created', 'provinces', 'regencies', 'address'])
                ->addIndexColumn()
                ->make();
        }

        return view('pages.admin.customer.reports');
    }
}
