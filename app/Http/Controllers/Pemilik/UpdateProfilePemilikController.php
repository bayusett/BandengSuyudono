<?php

namespace App\Http\Controllers\Pemilik;

use App\Models\User;
use App\Models\Regency;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UpdateProfilePemilikController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $prov = Province::all();
        $kabupatens = Regency::where('id', $user->regencies_id)->first();

        return view('pages.pemilik.profile.edit', [
            'user' => $user,
            'provinces' => $prov,
            'kabupaten' => $kabupatens,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required', 'min:3', 'max:255', 'string'],
            'email' => ['email', 'required', 'min:3', 'max:255', 'unique:users,email,' . auth()->id()],
            'photos' => ['image', 'mimes:png,jpg,jpeg', 'max:2048']
        ]);

        auth()->user()->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'provinces_id' => $request->provinces_id,
            'regencies_id' => $request->regencies_id,
        ]);

        return back()->with('message', 'Profil Anda telah diperbarui');
    }

    public function updatePicture(Request $request)
    {
        $path = 'users/images/';
        $file = $request->file('photos');
        $new_name = 'UIMG_' . date('Ymd') . uniqid() . '.jpg';

        //Upload new image
        $upload = $file->move(public_path($path), $new_name);

        if (!$upload) {
            return response()->json(['status' => 0, 'msg' => 'Terjadi masalah, upload gambar baru gagal.']);
        } else {
            //Get Old picture
            $oldPicture = User::find(Auth::user()->id)->getAttributes()['photos'];

            if ($oldPicture != '') {
                if (\File::exists(public_path($path . $oldPicture))) {
                    \File::delete(public_path($path . $oldPicture));
                }
            }

            //Update DB
            $update = User::find(Auth::user()->id)->update(['photos' => $new_name]);

            if (!$upload) {
                return response()->json(['status' => 0, 'msg' => 'Ada yang tidak beres, memperbarui gambar  gagal.']);
            } else {
                return response()->json(['status' => 1, 'msg' => 'Gambar profil Anda telah berhasil diperbarui']);
            }
        }
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
