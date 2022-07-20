<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\UserProfileController;
use App\Http\Controllers\Auth\RegisterController;

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

Route::get('/welcome', function () { return view('welcome'); });
Route::get('/', [LoginController::class, 'loginPage'])->name('login');
Route::get('/login', [LoginController::class, 'loginPage'])->name('login');
Route::get('/dashboard', [UserProfileController::class, 'dashboard'])->name('dashboard');
Route::post('/store-login', [LoginController::class, 'storeLogin'])->name('store-login');
Route::get('/logout', [LoginController::class, 'userLogout'])->name('logout');
Route::get('/register', [RegisterController::class, 'registerForm'])->name('register');
Route::post('/store-register', [RegisterController::class, 'storeRegister'])->name('store-register');

Route::get('/mi-perfil', [UserProfileController::class, 'miPerfil'])->name('mi-perfil');
Route::post('/update-perfil', [UserProfileController::class, 'updatePerfil'])->name('update-perfil');

Route::get('cambiar-contrasena', [UserProfileController::class, 'cambiarContrasena'])->name('cambiar-contrasena');
Route::post('update-contrasena', [UserProfileController::class, 'updateContrasena'])->name('update-contrasena');

Route::get('cita', [UserProfileController::class, 'cita'])->name('cita');
Route::get('cita/{id}', [UserProfileController::class, 'mostrarCita'])->name('mostrar-cita');
