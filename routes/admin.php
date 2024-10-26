<?php

use App\Http\Controllers\BannerController;
use App\Http\Controllers\BusController;
<<<<<<< HEAD
use App\Http\Controllers\ContactController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\NewCategoryController;
use App\Http\Controllers\RoleController;

use App\Http\Controllers\RouteController;
use App\Http\Controllers\StopController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\PromotionUserController;
=======
use App\Http\Controllers\BusSeatController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\NewCategoryController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\StopController;
use App\Http\Controllers\TripController;
>>>>>>> 5e72f5bd298277e513369229af78157ad3271f56
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->as('admin.')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::resource('contacts', ContactController::class);
<<<<<<< HEAD
    Route::resource('roles', RoleController::class);
=======
    Route::post('/status-contacts/{id}', [ContactController::class, 'statusContact']);

    Route::resource('roles', RoleController::class);
    Route::post('/status-roles/{id}', [RoleController::class, 'statusRole']);
>>>>>>> 5e72f5bd298277e513369229af78157ad3271f56

    Route::resource('buses', BusController::class);
    Route::post('/status-buses/{id}', [BusController::class, 'statusBuses']);

    Route::resource('banners', BannerController::class);
    Route::post('/status-banners/{id}', [BannerController::class, 'statusBanner']);

    Route::resource('new_categories',NewCategoryController::class);
    Route::post('/status-new-category/{id}', [App\Http\Controllers\NewCategoryController::class, 'statusNewCategory']);
<<<<<<< HEAD
    Route::post('/status-roles/{id}', [RoleController::class, 'statusRole']);
    Route::post('/status-contacts/{id}', [ContactController::class, 'statusContact']);
    Route::resource('information',InformationController::class);
=======
    
    Route::resource('information',InformationController::class);
    
>>>>>>> 5e72f5bd298277e513369229af78157ad3271f56
    Route::resource('routes', RouteController::class);
    Route::post('/status-route/{id}', [RouteController::class, 'statusRoute']);

    Route::resource('stops', StopController::class);
    Route::post('/status-stop/{id}', [StopController::class, 'statusStop']);

<<<<<<< HEAD
Route::resource('promotions', PromotionController::class);
Route::post('/status-promotion/{id}', [PromotionController::class, 'statusPromotion']);
=======
    Route::resource('trips', TripController::class);
    Route::post('/status-trip/{id}', [TripController::class, 'statusTrip']);

    Route::resource('bus_seats', BusSeatController::class);
    Route::post('/status-bus-seat/{id}', [BusSeatController::class, 'statusBusSeat']);

    Route::resource('reviews', ReviewController::class);
>>>>>>> 5e72f5bd298277e513369229af78157ad3271f56

});
