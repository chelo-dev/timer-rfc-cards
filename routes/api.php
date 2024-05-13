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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// Administracion cuenta
Route::group(['prefix' => '/', 'middleware' => 'auth'], function () {
    Route::get('/cuenta/{uuid}', [UserController::class, 'getAccount'])->name('getAccount');
    Route::put('/cuenta/{uuid}', [UserController::class, 'editAccount'])->name('editAccount');
});

// Administracion Usuarios
Route::group(['prefix' => 'administracion', 'middleware' => 'auth'], function () {
    Route::get('/usuarios', [UserController::class, 'listUser'])->name('listUser');
    Route::get('/usuario/{uuid}', [UserController::class, 'deatailUser'])->name('deatailUser');
    Route::post('/usuario/registrro', [UserController::class, 'createUser'])->name('createUser');
    Route::post('/usuario', [UserController::class, 'deleteUser'])->name('deleteUser');
});
