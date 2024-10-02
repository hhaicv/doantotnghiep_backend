<?php

<<<<<<< HEAD
use App\Http\Controllers\ContactController;
=======
>>>>>>> e45c32a2a3c60f0d0742f72e4f09b7ba7998d022
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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
<<<<<<< HEAD
    return view('welcome');
});

//Route::resource('contacts', ContactController::class);
=======
    return view('admin.dashboard');
})->name('dashboard');
>>>>>>> e45c32a2a3c60f0d0742f72e4f09b7ba7998d022
