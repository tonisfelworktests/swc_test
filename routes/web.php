<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
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
    return view('welcome');
});

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/home', [EventController::class, 'index'])->name('home');
    Route::get('/profile/{id?}', [HomeController::class, 'profile'])->name('admin.settings');
    Route::post('/profile/change', [UserController::class, 'update'])->name('update-profile');
    Route::get('/event/{id}', [EventController::class, 'watch'])->name('events-watch');

    Route::post('/event/{id}/join', [EventController::class, 'join'])->name('event-join');
    Route::post('/event/{id}/leave', [EventController::class, 'leave'])->name('event-leave');
});
