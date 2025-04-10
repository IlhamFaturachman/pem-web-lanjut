<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) { // jika sudah login, maka redirect ke halaman home
            return redirect('/');
        }
        return view('auth.login');
    }

    public function postlogin(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $credentials = $request->only('username', 'password');
            if (Auth::attempt($credentials)) {
                return response()->json([
                    'status' => true,
                    'message' => 'Login Berhasil',
                    'redirect' => url('/')
                ]);
            }
            return response()->json([
                'status' => false,
                'message' => 'Login Gagal'
            ]);
        }
        return redirect('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }

    // === Tambahan ===

    public function register()
    {
        return view('auth.register');
    }

    public function postregister(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:m_user,username',
            'nama' => 'required|string|max:255',
            'password' => 'required|min:6|confirmed'
        ]);

        // Cari level dengan kode CUS
        $level = LevelModel::where('level_kode', 'CUS')->first();

        if (!$level) {
            return back()->withErrors(['level' => 'Level dengan kode CUS tidak ditemukan.']);
        }

        $user = new UserModel();
        $user->username = $request->username;
        $user->nama = $request->nama;
        $user->password = $request->password;
        $user->level_id = $level->level_id;
        $user->save();

        return redirect('login')->with('success', 'Registrasi berhasil, silakan login!');
    }
}
