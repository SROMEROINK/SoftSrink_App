<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\MpIngresoController;
use App\Http\Controllers\ListadoOfController;
use App\Http\Controllers\ProductoCategoriaController;
use App\Http\Controllers\RegistroDeFabricacionController;



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
Route::get('/listado_de_of', [ListadoOfController::class, 'index'])->name('listado_de_of.index'); 
Route::get('/productos_categoria',[ProductoCategoriaController::class,'index'])->name('productos_categoria.index');
Route::get('/registro_de_fabricacion',[RegistroDeFabricacionController::class,'index'])->name('registro_de_fabricacion.index');


// Rutas para el CRUD de productos en el área general (Si existe)
Route::resource('productos', ProductoController::class);

// Esta ruta lleva al formulario de edición de un producto específico
Route::get('/productos/{producto}/edit', [ProductoController::class, 'edit'])->name('productos.edit');

// Esta ruta procesa la solicitud de eliminación de un producto específico
Route::delete('/productos/{producto}', [ProductoController::class, 'destroy'])->name('productos.destroy');

Route::resource('mp_ingresos', MpIngresoController::class);

Route::resource('categoria', ProductoCategoriaController::class);

Route::resource('registro_de_fabricacion',RegistroDeFabricacionController::class);







