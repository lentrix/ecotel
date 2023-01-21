<?php

use App\Http\Controllers\AddonController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if(!auth()->guest()) return redirect('/home');
    return view('login');
})->name('login');

Route::post('/login',[SiteController::class, 'login']);
Route::post('/logout', [SiteController::class, 'logout'])->middleware('auth');

Route::middleware(['auth'])->group(function() {

    Route::get('/home',[SiteController::class, 'home']);

    Route::get('/bookings',[BookingController::class,'index']);

    Route::post('/guests/search',[Guestcontroller::class,'index']);
    Route::get('/guests/{guest}',[GuestController::class,'show']);
    Route::patch('/guests/{guest}',[GuestController::class,'update']);
    Route::post('/guests',[GuestController::class, 'store']);
    Route::get('/guests',[GuestController::class,'index']);

    Route::get('/bookings/create/{guest}',[BookingController::class, 'create']);
    Route::post('/bookings/create/page2/{guest}',[BookingController::class, 'create2']);
    Route::post('/bookings/create/page3/{guest}',[BookingController::class, 'create3']);
    Route::post('/bookings/create/finalize',[BookingController::class, 'store']);
    Route::post('/bookings/add-guest/{booking}',[BookingController::class, 'addGuest']);
    Route::post('/bookings/remove-guest/{booking}',[BookingController::class, 'removeGuest']);
    Route::post('/bookings/add-on/{booking}',[BookingController::class, 'addAddonItem']);
    Route::post('/bookings/confirm/{booking}',[BookingController::class, 'confirmBooking']);
    Route::post('/bookings/cancel/{booking}',[BookingController::class, 'cancelBooking']);
    Route::delete('/bookings/add-on/{booking}',[BookingController::class, 'removeAddonItem']);
    Route::get('/bookings/{booking}',[BookingController::class, 'show']);

    Route::get('/reports',[ReportController::class,'index']);

    Route::middleware('role:admin')->group(function(){

        Route::get('/rooms/{room}', [RoomController::class, 'show']);
        Route::get('/rooms', [RoomController::class, 'index']);
        Route::post('/rooms', [RoomController::class, 'store']);
        Route::patch('/rooms', [RoomController::class, 'update']);
        Route::delete('/rooms', [RoomController::class, 'destroy']);

        Route::get('/addons/{addon}', [AddonController::class, 'show']);
        Route::get('/addons', [AddonController::class, 'index']);
        Route::post('/addons', [AddonController::class, 'store']);
        Route::patch('/addons/{addon}', [AddonController::class, 'update']);
        Route::delete('/addons/{addon}', [AddonController::class, 'destroy']);

        Route::get('/users/{user}', [UserController::class, 'show']);
        Route::get('/users', [UserController::class, 'index']);
        Route::post('/users', [UserController::class, 'store']);
        Route::post('/users/change-password/{user}', [UserController::class, 'changePassword']);
        Route::patch('/users/{user}', [UserController::class, 'update']);
        Route::delete('/users/{user}', [UserController::class, 'destroy']);
    });

});
