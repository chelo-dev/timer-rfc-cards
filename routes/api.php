<?php

use App\Http\Controllers\administration\User\UserController;
use App\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

# Administracion de empresa
Route::prefix('administration')->middleware('auth:sanctum')->controller(UserController::class)->group(function () {
    Route::post('/obtener-cuenta', 'getAccount');
    Route::post('/editar-cuenta', 'editAccount');
});

// Administracion Usuarios
Route::prefix('administration')->middleware('auth:sanctum')->controller(UserController::class)->group(function () {
    Route::get('/usuarios', 'listUser');
    Route::post('/obtener-usuario', 'deatailUser');
    Route::post('/registro-usuario', 'createUser');
    Route::post('/eliminar-usuario', 'deleteUser');
});
