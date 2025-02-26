<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\RegistroController;
use App\Http\Controllers\ControlValesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FoodUserController;
use App\Http\Controllers\MisValesController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UsuariosAsociadosController;
use App\Http\Controllers\ValesController;
use App\Models\FoodUser;
use Barryvdh\DomPDF\Facade\Pdf;
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

    Route::get('/perfil/{userId}', [PerfilController::class, 'verPerfilUsuario'])->name('perfil.ver');

    Route::post('/saveSeleccion', [FoodUserController::class, 'guardarRacionesSeleccionadas'])->name('saveSeleccion');

    Route::get('/dashboard/vales/{userId}', [FoodUserController::class, 'valesTodayByUser'])->name('valesTodayByUser');
    Route::get('/dashboard/vales/editar/{userId}', [FoodUserController::class, 'valesTodayByDate'])->name('valesTodayByDate');
    Route::get('/dashboard/filtro/{date}', [DashboardController::class, 'filtroByDate'])->name('filtroByDate');
    Route::post('/dashboard/vales/editar', [FoodUserController::class, 'editValesByUser'])->name('valesTodayByUser');

    Route::delete('/usuario/{userId}', [UsuariosAsociadosController::class, 'destroy']);

    Route::get('/descargar-reportes', [ReportController::class, 'goToDescargarReportesView'])->name('descargarReportes');
    Route::post('/generar-pdf', [ReportController::class, 'generatePDF'])->name('generarPDF');
    Route::post('/generar-pdf-hoy', [ReportController::class, 'generatePDFHoy'])->name('generarPDFHoy');
    Route::post('/generar-pdf-fecha', [ReportController::class, 'generatePDFFecha'])->name('generarPDFFecha');

    Route::post('/usuario/rol', [PerfilController::class, 'CambiarRol']);

    Route::get('/vales', [ValesController::class, 'goToValesView'])->name('vales');
    Route::get('/getVales', [ValesController::class, 'getVales'])->name('getVales');
    Route::post('/crearVale', [ValesController::class, 'crearVale'])->name('crearVale');
    Route::post('/editarVale', [ValesController::class, 'editarVale'])->name('editarVale');
    Route::post('/eliminarVale', [ValesController::class, 'eliminarVale'])->name('eliminarVale');

    Route::get('/control-vales', [ControlValesController::class, 'goToControlValesView'])->name('controlVales');
    Route::get('/getValesDiarios/{valeId}', [ControlValesController::class, 'getValesDiarios'])->name('getValesDiarios');
    Route::post('/cambiarEstadoVale', [ControlValesController::class, 'cambiarEstadoVale'])->name('cambiarEstadoVale');


});

Route::post('/registro', [RegistroController::class, 'registro'])->name('registro-user');
Route::post('/login', [LoginController::class, 'login'])->name('login-user');
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout-user');

Route::get('recuperar-password', static function () {
    return view('recovery');
})->name('recuperar-password');

Route::post('/recuperar-password-code', [PasswordController::class, 'sendCodeResetPassword'])->name('reset-password-code');
Route::post('/verificar-password-code', [PasswordController::class, 'verificarCodeResetPassword'])->name('verificar-reset-password-code');
Route::post('/resetear-password', [PasswordController::class, 'resetearPassword'])->name('resetear-password');

Route::get('/resetpassword', [PasswordController::class, 'showResetPasswordForm'])->name('resetpassword');
