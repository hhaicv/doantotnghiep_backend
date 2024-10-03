<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\NewCategoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->as('admin.')->group(function () {
    Route::get('/', function (){
        return view('admin.dashboard');
    })->name('dashboard');
    Route::resource('contacts', ContactController::class);
    Route::resource('newcategories', NewCategoryController::class);

});
