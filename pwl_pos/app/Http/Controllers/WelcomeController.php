<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $user = auth()->user(); // Ambil user login
        $breadcrumb = (object)[
            'title' => 'Selamat Datang',
            'list' => ['Home', 'Welcome'],
        ];

        $activeMenu = 'dashboard';

        // Cek role dan arahkan ke view berbeda
        switch ($user->level->level_kode) {
            case 'ADM':
                return view('dashboard.admin', [
                    'breadcrumb' => $breadcrumb,
                    'activeMenu' => $activeMenu,
                ]);
            case 'MNG':
                return view('dashboard.manager', [
                    'breadcrumb' => $breadcrumb,
                    'activeMenu' => $activeMenu,
                ]);
            case 'STF':
                return view('dashboard.staff', [
                    'breadcrumb' => $breadcrumb,
                    'activeMenu' => $activeMenu,
                ]);
            case 'CUS':
                return view('dashboard.customer', [
                    'breadcrumb' => $breadcrumb,
                    'activeMenu' => $activeMenu,
                ]);
            default:
                abort(403, 'Role tidak dikenali');
        }
    }
}
