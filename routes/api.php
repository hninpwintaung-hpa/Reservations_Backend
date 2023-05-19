<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CarController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\TeamController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CarReservationController;
use App\Http\Controllers\Api\RoomReservationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::apiResource('teams', TeamController::class);
// Route::apiResource('teams', TeamController::class)->middleware('auth:sanctum');
Route::apiResource('roles', RoleController::class)->middleware('auth:sanctum');
Route::delete('/users/user_delete/{id}', [UserController::class, 'userDelete'])
    ->middleware('auth:sanctum');

Route::delete('/users/admin_delete/{id}', [UserController::class, 'adminDelete'])
    ->middleware('auth:sanctum');

Route::apiResource('users', UserController::class)->middleware('auth:sanctum');
Route::apiResource('rooms', RoomController::class);
Route::apiResource('cars', CarController::class);
Route::apiResource('car_reservation', CarReservationController::class);
Route::apiResource('room_reservation', RoomReservationController::class);
Route::post('room_reservation/searchByDate', [RoomReservationController::class, 'searchByDate'])->name('room_reservation.searchByDate');
