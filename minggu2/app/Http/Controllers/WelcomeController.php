<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function hello(){ // Mendefinisikan method hello
        return 'hello world';
    }

    //menampilkan view dari controller
    public function greeting(){ // Mendefinisikan method greeting
        return view('blog.hello')
        //dibawah menambahkan fungsi untuk praktikum meneruskan data ke view 
        ->with('name', 'Ilham Faturachman Keren') //meneruskan data ke view
        ->with('occupation', 'Astrounout'); //meneruskan data ke view
    }
}