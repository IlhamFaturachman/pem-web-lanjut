<?php

use Illuminate\Support\Facades\Route; // Mengimpor fasad Route untuk mendefinisikan rute
use App\Http\Controllers\ItemController; // Mengimpor ItemController untuk digunakan dalam rute
use App\Http\Controllers\WelcomeController; // Mengimpor WelcomeController untuk digunakan dalam rute
use App\Http\Controllers\PageController; // Mengimpor PageController untuk digunakan dalam rute
use App\Http\Controllers\AboutController; // Mengimpor AboutController untuk digunakan dalam rute
use App\Http\Controllers\ArticleController; // Mengimpor ArticleController untuk digunakan dalam rute
use App\Http\Controllers\HomeController; // Mengimpor HomeController untuk digunakan dalam rute
use App\Http\Controllers\PhotoController; // Mengimpor PhotoController untuk digunakan dalam rute

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () { // Mendefinisikan rute GET untuk halaman utama ('/')
    return view('welcome'); // Mengembalikan tampilan 'welcome'
});

Route::resource('items', ItemController::class); // Membuat resource route untuk ItemController yang mencakup CRUD otomatis





// Route::get('/hello', function () { // Mendefinisikan rute GET untuk halaman home ('/home')
//     return 'hello world';
// });

Route::get('/hello',  [WelcomeController::class, 'hello']); // Mendefinisikan rute GET untuk halaman home ('/home')

// Route GET untuk halaman utama
Route::get('/', [PageController::class, 'index']); // Mendefinisikan rute GET untuk halaman utama

// Route GET untuk halaman about
Route::get('/about', [PageController::class, 'about']); // Mendefinisikan rute GET untuk halaman about

// Route GET untuk halaman artikel dengan parameter {id}
Route::get('/articles/{id}', [PageController::class, 'articles']);  // Mendefinisikan rute GET untuk halaman artikel


Route::get('/world', function () { // Mendefinisikan rute GET untuk halaman world
    return 'world';
});

Route::get('/', function () { // Mendefinisikan rute GET untuk halaman utama
    return 'Selamat Datang';
});

Route::get('/about', function () {      // Mendefinisikan rute GET untuk halaman about
    return 'Nama : Ilham Faturachman
    NIM : 244107023001';
});


// Route::get('/user/{name}', function ($name) {
//     return 'Ilham Faturachman '.$name;
//     }); 


Route::get('/posts/{post}/comments/{comment}', function ($postId, $commentId) { // Mendefinisikan rute GET untuk halaman artikel
    return 'Pos ke-' . $postId . " Komentar ke-: " . $commentId;
});

Route::get('/articles/{id}', function ($id) { // Mendefinisikan rute GET untuk halaman artikel
    return "Halaman Artikel dengan ID $id";
});

Route::get('/user/{name?}', function ($name = 'john') { // Mendefinisikan rute GET untuk halaman user
    return 'Nama saya ' . $name;
});

//Resource Controller
Route::get('/', [HomeController::class, 'index']); // Mendefinisikan rute GET untuk halaman utama ('/')
Route::get('/about', [AboutController::class, 'about']); // Mendefinisikan rute GET untuk halaman about
Route::get('/articles/{id}', [ArticleController::class, 'articles']); // Mendefinisikan rute GET untuk halaman artikel

Route::resource('photos', PhotoController::class); // Mendefinisikan rute resource untuk PhotoController

Route::resource('photos', PhotoController::class)->only([ // Mendefinisikan rute resource untuk PhotoController dengan hanya menggunakan method tertentu
    'index',
    'show'
]);
Route::resource('photos', PhotoController::class)->except([ // Mendefinisikan rute resource untuk PhotoController dengan hanya menggunakan method tertentu
    'create',
    'store',
    'update',
    'destroy'
]);

//view dalam direktori
// Route::get('/greeting', function () { // Mendefinisikan rute GET untuk halaman greeting
//     return view('blog.hello', ['name' => 'Ilham Faturachman']); // Mengembalikan tampilan 'hello' dengan data 'name'
// });

//menampilkan view dari Controller
Route::get('/greeting', [WelcomeController::class, 'greeting']); // Mendefinisikan rute GET untuk halaman greeting