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
            'level_id' => 2,
            'username' => 'manager_dua',
            'nama' => 'Manager 2',
            'password' => Hash::make('12345678'),
        ];

        UserModel::create($data);

        $user = UserModel::all(); // mengambil data dari table m_user
        return view('user', ['data' => $user]);
    }
}
