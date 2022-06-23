<?php

namespace App\Http\Controllers;

use App\Models\Regency;
use App\Models\Customer;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardProfileController extends Controller
{
    public function edit()
    {
        $customer = Auth::guard('customer')->user();
        $provinsi = Province::all();
        $kabupatens = Regency::where('id', $customer->regencies_id)->first();

        return view('pages.profile-edit', [
            'customer' => $customer,
            'provinces' => $provinsi,
            'kabupaten' => $kabupatens,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required', 'min:3', 'max:255', 'string'],
            'email' => ['email', 'required', 'min:3', 'max:255', 'unique:customers,email,' . Auth::guard('customer')->id()],
            'photos' => ['image', 'mimes:png,jpg,jpeg', 'max:2048']
        ]);

        Auth::guard('customer')->user()->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'provinces_id' => $request->provinces_id,
            'regencies_id' => $request->regencies_id,
        ]);

        return back()->with('message', 'Profil Anda telah diperbarui');
    }

    function updatePicture(Request $request)
    {
        $path = 'customers/images/';
        $file = $request->file('photos');
        $new_name = 'UIMG_' . date('Ymd') . uniqid() . '.jpg';

        //Upload new image
        $upload = $file->move(public_path($path), $new_name);

        if (!$upload) {
            return response()->json(['status' => 0, 'msg' => 'Terjadi masalah, upload gambar baru gagal.']);
        } else {
            //Get Old picture
            $oldPicture = Customer::find(Auth::guard('customer')->user()->id)->getAttributes()['photos'];

            if ($oldPicture != '') {
                if (\File::exists(public_path($path . $oldPicture))) {
                    \File::delete(public_path($path . $oldPicture));
                }
            }

            //Update DB
            $update = Customer::find(Auth::guard('customer')->user()->id)->update(['photos' => $new_name]);

            if (!$upload) {
                return response()->json(['status' => 0, 'msg' => 'Ada yang tidak beres, memperbarui gambar  gagal.']);
            } else {
                return response()->json(['status' => 1, 'msg' => 'Gambar profil Anda telah berhasil diperbarui']);
            }
        }
    }
}
