<?php


use App\Http\Controllers\ContactController;

<<<<<<< HEAD

=======
>>>>>>> b0e74ed34f6d330a91b732d6d68e6bf37da72131
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
<<<<<<< HEAD
    return view('welcome');
});

Route::resource('contacts', ContactController::class);

// Route cho dashboard cần được viết đầy đủ với dấu {}
Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->name('dashboard');
=======

    return view('welcome');
});


>>>>>>> b0e74ed34f6d330a91b732d6d68e6bf37da72131

