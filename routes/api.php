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
use App\Models\CarReservation;
use App\Models\RoomReservation;

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

Route::post('teams', [TeamController::class, 'store'])->middleware('auth:sanctum');
Route::get('teams', [TeamController::class, 'index']);
Route::patch('teams/{id}', [TeamController::class, 'update'])->middleware('auth:sanctum');
Route::delete('teams/{id}', [TeamController::class, 'destroy'])->middleware('auth:sanctum');

Route::apiResource('roles', RoleController::class)->middleware('auth:sanctum');
Route::delete('/users/user_delete/{id}', [UserController::class, 'userDelete'])
    ->middleware('auth:sanctum');

Route::delete('/users/admin_delete/{id}', [UserController::class, 'adminDelete'])
    ->middleware('auth:sanctum');

Route::patch('status_change/{id}', [UserController::class, 'statusChange'])->middleware('auth:sanctum');

Route::apiResource('users', UserController::class)->middleware('auth:sanctum');
Route::apiResource('rooms', RoomController::class)->middleware('auth:sanctum');
Route::apiResource('cars', CarController::class)->middleware('auth:sanctum');
Route::apiResource('car_reservation', CarReservationController::class)->middleware('auth:sanctum');
Route::apiResource('room_reservation', RoomReservationController::class)->middleware('auth:sanctum');

Route::get('pro_user', [UserController::class, 'getProUser']);
Route::get('staff', [UserController::class, 'getStaff']);
Route::post('room_reservation/searchByDate', [RoomReservationController::class, 'searchByDate'])->name('room_reservation.searchByDate')->middleware('auth:sanctum');


Route::post('room_reservation/searchByDate', [RoomReservationController::class, 'searchByDate'])->name('room_reservation.searchByDate')->middleware('auth:sanctum');
Route::get('room_reservation/searchByUserAndDate/{id}/{date}', [RoomReservationController::class, 'searchByUserAndDate'])->name('room_reservation.searchByUserAndDate')->middleware('auth:sanctum');


Route::get('car_count', [CarController::class, 'getCarCount'])->middleware('auth:sanctum');
Route::get('room_count', [RoomController::class, 'getRoomCount'])->middleware('auth:sanctum');
Route::get('car_reserve_count', [CarReservationController::class, 'getCarReserveCount'])->middleware('auth:sanctum');
Route::get('room_reserve_count', [RoomReservationController::class, 'getRoomReserveCount'])->middleware('auth:sanctum');
Route::get('room_reserve_count_by_team', [RoomReservationController::class, 'getRoomReserveCountByTeam'])->middleware('auth:sanctum');
Route::get('car_reserve_count_by_team', [CarReservationController::class, 'getCarReserveCountByTeam'])->middleware('auth:sanctum');
Route::get('room_reserve_count_by_id/{id}', [RoomReservationController::class, 'getRoomReserveCountById'])->middleware('auth:sanctum');
Route::get('car_reserve_count_by_id/{id}', [CarReservationController::class, 'getCarReserveCountById'])->middleware('auth:sanctum');

Route::get('room_reserve_count_by_month', [RoomReservationController::class, 'getRoomReservationCountByMonth'])->middleware('auth:sanctum');
Route::get('car_reserve_count_by_month', [CarReservationController::class, 'getCarReservationCountByMonth'])->middleware('auth:sanctum');
Route::get('getCarReservationSearchByDate/{date}', [CarReservationController::class, 'getCarReservationSearchByDate'])->middleware('auth:sanctum');
