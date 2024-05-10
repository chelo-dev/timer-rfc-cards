<?php

use App\Http\Controllers\administration\User\UserController;
use App\Http\Controllers\Config\LanguageController;
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
    return view('auth.login');
});

// Usando el método middleware() para aplicar el middleware 'web'
Route::middleware('web')->get('lang/{locale}', [LanguageController::class, 'changeLanguage'])->name('changeLang');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Administracion cueneta
Route::group(['prefix' => '/', 'middleware' => 'auth'], function () {
    Route::get('/cuenta/{uuid}', [UserController::class, 'getAccount'])->name('getAccount');
    Route::put('/cuenta/{uuid}', [UserController::class, 'editAccount'])->name('editAccount');
});

// Administracion Usuarios
Route::group(['prefix' => 'administracion', 'middleware' => 'auth'], function () {
    Route::get('/usuarios', [UserController::class, 'listUser'])->name('listUser');
    Route::get('/usuario/{uuid}', [UserController::class, 'deatailUser'])->name('deatailUser');
    Route::delete('/usuario', [UserController::class, 'deleteUser'])->name('deleteUser');
});

require __DIR__ . '/auth.php';
