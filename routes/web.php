<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\MpIngresoController;


// Ruta por defecto al iniciar la app
Route::get('/', function () {
    return view('welcome');
});



// Rutas de autenticación
Auth::routes();

// Rutas hacia el HomeController
Route::get('/home', [AdminHomeController::class, 'index'])->name('adminHome');
Route::get('/admin', [AdminHomeController::class, 'index'])->name('admin.index');
Route::get('/materia_prima', [MpIngresoController::class, 'index'])->name('materia_prima.index');

// Rutas para el CRUD de productos en el área general (Si existe)
Route::resource('productos', ProductoController::class);

// Esta ruta lleva al formulario de edición de un producto específico
Route::get('/productos/{producto}/edit', [ProductoController::class, 'edit'])->name('productos.edit');

// Esta ruta procesa la solicitud de eliminación de un producto específico
Route::delete('/productos/{producto}', [ProductoController::class, 'destroy'])->name('productos.destroy');

Route::resource('mp_ingresos', MpIngresoController::class);






