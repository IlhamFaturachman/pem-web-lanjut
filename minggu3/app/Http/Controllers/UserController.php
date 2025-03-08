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
        $data = [
            'nama' => 'Pelanggan Pertama',
        ];

        UserModel::where('username', 'customer-1')->update($data);

        $user = UserModel::all(); // mengambil data dari table m_user
        return view('user', ['data' => $user]);
    }
}
