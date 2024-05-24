<?php

use App\Http\Controllers\ScheduleEntrie\ScheduleEntrieController;
use App\Http\Controllers\administration\User\UserController;
use App\Http\Controllers\Department\DepartmentController;
use App\Http\Controllers\Position\PositionController;
use App\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Support\Facades\Route;

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

# Administracion de cuenta de usuarios
Route::prefix('administration')->middleware('auth:sanctum')->controller(UserController::class)->group(function () {
    Route::post('/obtener-cuenta', 'getAccount');
    Route::post('/editar-cuenta', 'editAccount');
});

// Administracion Usuarios
Route::prefix('administration')->middleware('auth:sanctum')->controller(UserController::class)->group(function () {
    Route::get('/usuarios', 'listUser');
    Route::post('/obtener-usuario', 'deatailUser');
    Route::post('/registro-usuario', 'createUser');
    Route::post('/editar-usuario', 'editUser');
    Route::post('/eliminar-usuario', 'deleteUser');
    Route::post('/importar-usuarios', 'importUsers');
    Route::post('/exportar-usuarios', 'exportUsers');
});

// Administración de Departamentos
Route::prefix('administration')->middleware('auth:sanctum')->controller(DepartmentController::class)->group(function () {
    Route::get('/departamentos', 'listDepartment');
    Route::post('/obtener-departamento', 'showDepartment');
    Route::post('/registro-departamento', 'createDepartment');
    Route::post('/editar-departamento', 'editDepartment');
    Route::post('/eliminar-departamento', 'deleteDepartment');
    Route::post('/importar-departamentos', 'importDepartments');
    Route::post('/exportar-departamentos', 'exportDepartments');
});

// Administración de Posiciones
Route::prefix('administration')->middleware('auth:sanctum')->controller(PositionController::class)->group(function () {
    Route::get('/posiciones', 'listPosition');
    Route::post('/obtener-posicion', 'showPosition');
    Route::post('/registro-posicion', 'createPosition');
    Route::post('/editar-posicion', 'editPosition');
    Route::post('/eliminar-posicion', 'deletePosition');
});

// Administración de Posiciones
Route::prefix('administration')->controller(ScheduleEntrieController::class)->group(function () {
    Route::post('/checkIn', 'checkIn');
    Route::post('/checkOut', 'checkOut');
});
