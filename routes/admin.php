<?php

use App\Http\Controllers\ContactController;
<<<<<<< HEAD
use App\Http\Controllers\NewCategoryController;
=======
use App\Http\Controllers\RoleController;
>>>>>>> b0e74ed34f6d330a91b732d6d68e6bf37da72131
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->as('admin.')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');
<<<<<<< HEAD
    Route::resource('contacts', ContactController::class);
    Route::resource('newcategories', NewCategoryController::class);
=======
>>>>>>> b0e74ed34f6d330a91b732d6d68e6bf37da72131

    Route::resource('contacts', ContactController::class);
    Route::resource('roles', RoleController::class);
});
