<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Monolog\Level;

class UserController extends Controller
{
    public function index()
    {
        $data = UserModel::with('level')->get();
        return view('user', compact('data'));
    }

    public function tambah()
    {
        return view('user_tambah');
    }
    public function tambah_simpan(Request $request)
    {
        userModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => Hash::make($request->password),
            'level_id' => $request->level_id
        ]);
        return redirect('/user');
    }
    public function ubah($id)
    {
        $data = UserModel::find($id);
        return view('user_ubah', compact('data'));
    }

    public function ubah_simpan(Request $request, $id)
    {
        $data = UserModel::find($id);

        $data->username = $request->username;
        $data->nama = $request->nama;
        $data->password = Hash::make($request->password);
        $data->level_id = $request->level_id;

        $data->save();

        return redirect('/user');
    }
    public function hapus($id)
    {
        $data = UserModel::find($id);
        $data->delete();
        return redirect('/user');
    }
}
