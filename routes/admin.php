<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\RoleController;
use App\Models\Contact;
use App\Models\Role;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->as('admin.')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::prefix('role')
        ->as('role.')
        ->group(function () {
            Route::get('/',                 [RoleController::class, 'index'])->name('index');
            Route::get('create',            [RoleController::class, 'create'])->name('create');
            Route::post('store',            [RoleController::class, 'store'])->name('store');
            Route::get('{id}/edit',         [RoleController::class, 'edit'])->name('edit');
            Route::put('{id}/update',       [RoleController::class, 'update'])->name('update');
            Route::get('{id}/destroy',      [RoleController::class, 'destroy'])->name('destroy');
        });
    Route::prefix('contact')
        ->as('contact.')
        ->group(function () {
            Route::get('/',                 [ContactController::class, 'index'])->name('index');
            Route::get('create',            [ContactController::class, 'create'])->name('create');
            Route::post('store',            [ContactController::class, 'store'])->name('store');
            Route::get('{id}/edit',         [ContactController::class, 'edit'])->name('edit');
            Route::put('{id}/update',       [ContactController::class, 'update'])->name('update');
            Route::get('{id}/destroy',      [ContactController::class, 'destroy'])->name('destroy');
        });
});
