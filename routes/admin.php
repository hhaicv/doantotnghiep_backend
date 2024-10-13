<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\NewCategoryController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->as('admin.')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::resource('contacts', ContactController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('new_categories',NewCategoryController::class);
    Route::post('/status-new-category/{id}', [App\Http\Controllers\NewCategoryController::class, 'statusNewCategory']);
    Route::post('/status-roles/{id}', [RoleController::class, 'statusRole']);
    Route::post('/status-contacts/{id}', [ContactController::class, 'statusContact']);
    Route::resource('information',InformationController::class);
});
