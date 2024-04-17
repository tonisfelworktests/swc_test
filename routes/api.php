<?php

use App\Http\Controllers\Api\APIEventController;
use App\Http\Controllers\Api\APIParticipantController;
use App\Http\Controllers\Api\APIUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/clients', [APIUserController::class, 'getToken']);
Route::put('/registration', [APIUserController::class, 'register']);

Route::middleware('auth:api')->group(function () {
    Route::get('/events', [APIEventController::class, 'index'])->name('api-event-list');
    Route::put('/events/create', [APIEventController::class, 'store']);
    Route::delete('/events/{id}', [APIEventController::class, 'delete']);
    Route::post('/events/{id}', [APIEventController::class, 'update']);
    Route::get('/events/{id}', [APIEventController::class, 'watch']);

    Route::get('/events/participants/{id}', [APIParticipantController::class, 'watch']);
    Route::put('/events/participants/{id}', [APIParticipantController::class, 'store']);
    Route::delete('/events/participants/{id}', [APIParticipantController::class, 'delete']);
});
