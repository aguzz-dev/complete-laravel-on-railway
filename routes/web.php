<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegistroController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FoodUserController;
use App\Http\Controllers\MisValesController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\UsuariosAsociadosController;
use App\Models\FoodUser;
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
})->name('login');

Route::get('/registro', function () {
    return view('welcome');
});

Route::get('/registro/{code}', [RegistroController::class, 'goToRegistroView']);

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [DashboardController::class, 'goToDashboardView'])->name('dashboard');

    Route::get('/seleccionar', [FoodUserController::class, 'goToSeleccionarView'])->name('seleccionar');

    Route::get('/mis-vales', [MisValesController::class, 'goToMisValesView'])->name('misVales');

    Route::get('/listado-usuarios', [UsuariosAsociadosController::class, 'goToUsuariosAsociadosView'])->name('usuariosListado');

    Route::post('/perfil/actualizar', [PerfilController::class, 'updatePerfil'])->name('perfil.actualizar');

    Route::get('/perfil', [PerfilController::class, 'goToPerfilView'])->name('perfil');

    Route::post('/saveSeleccion', [FoodUserController::class, 'guardarRacionesSeleccionadas'])->name('saveSeleccion');

    Route::get('/dashboard/vales/{userId}', [FoodUserController::class, 'valesTodayByUser'])->name('valesTodayByUser');

    Route::post('/dashboard/vales/editar', [FoodUserController::class, 'editValesByUser'])->name('valesTodayByUser');
});

Route::post('/registro', [RegistroController::class, 'registro'])->name('registro-user');
Route::post('/login', [LoginController::class, 'login'])->name('login-user');
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout-user');
