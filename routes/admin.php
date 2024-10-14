<?php

use App\Http\Controllers\BannerController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NewCatagoryController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->as('admin.')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::resource('contacts', ContactController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('banners', BannerController::class);
    Route::resource('new_categories', NewCatagoryController::class);
    Route::post('/status-new-category/{id}', [NewCatagoryController::class, 'statusNewCategory']);
    Route::post('/status-roles/{id}', [RoleController::class, 'statusRole']);
    Route::post('/status-contacts/{id}', [ContactController::class, 'statusContact']);
    Route::post('/status-banners/{id}', [BannerController::class, 'statusBanner']);
});
