<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\ChecadorController;

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

Route::get('/ingresar', [LoginController::class, 'index'])->name('ingresar');
Route::post('/ingresar', [LoginController::class, 'login']);
Route::get('/salir', [LoginController::class, 'logout'])->name('salir');

Route::get('checador', [ChecadorController::class, 'indexChecador'])->name('checador.index');
Route::post('checador/validacion', [ChecadorController::class, 'getValidacionFoto']);
Route::post('checador/registro', [ChecadorController::class, 'storeRegistro']);

Route::group([
	'middleware' => [
		'autorizacion',
	]
], function () {

	// Rutas para Cambiar Contraseña
	Route::get('/cambiar-password', [LoginController::class, 'changePassword'])->name('cambiar-password');
	Route::put('/cambiar-password', [LoginController::class, 'changePasswordUpdate'])->name('cambiar-password.update');

	// Rutas del HomeController
	Route::resource('/', HomeController::class)->only(['index']);

	Route::resource('checadores', ChecadorController::class);
	Route::get('lista/checadores', [ChecadorController::class, 'list'])->name('checadores.list');
	Route::post('checador/descargaRegistros', [ChecadorController::class, 'descargaRegistros']);

	Route::resource('empleados', EmpleadoController::class);
	Route::get('lista/empleados', [EmpleadoController::class, 'list'])->name('empleados.list');
	Route::post('empleado/descargaRegistros', [EmpleadoController::class, 'descargaRegistros']);

});