<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\MpIngresoController;
use App\Http\Controllers\MpSalidaController;
use App\Http\Controllers\ListadoOfController;
use App\Http\Controllers\ProductoCategoriaController;
use App\Http\Controllers\RegistroDeFabricacionController;
use App\Http\Controllers\ListadoEntregaProductoController;


// Ruta por defecto al iniciar la app
Route::get('/', function () {
    return view('auth\login');
})->name('login');

// Rutas de autenticación
Auth::routes();

// Rutas hacia el HomeController
Route::get('/home', [AdminHomeController::class, 'index'])->name('adminHome');
Route::get('/admin', [AdminHomeController::class, 'index'])->name('admin.index');
Route::get('/materia_prima_ingresos', [MpIngresoController::class, 'index'])->name('materia_prima_ingresos.index');
Route::get('/materia_prima_salidas', [MpSalidaController::class, 'index'])->name('materia_prima_salidas.index');
Route::get('/listado_de_of', [ListadoOfController::class, 'index'])->name('listado_de_of.index'); 
Route::get('/productos_categoria',[ProductoCategoriaController::class,'index'])->name('productos_categoria.index');
    

Route::get('/entregas_productos',[ListadoEntregaProductoController::class,'index'])->name('entregas_productos.index');

// Dentro de web.php
Route::get('/listado-of/get-id-producto/{nroOf}', [ListadoOfController::class, 'getIdProductoPorNroOf']);


// Rutas para el CRUD de productos en el área general (Si existe)
Route::resource('productos', ProductoController::class);


Route::resource('mp_ingresos', MpIngresoController::class);

Route::resource('categoria', ProductoCategoriaController::class);

// Crea todas las rutas necesarias para CRUD: index, create, store, show, edit, update, delete
Route::resource('fabricacion', RegistroDeFabricacionController::class);

// Route::resource('fabricacion', RegistroDeFabricacionController::class)->except(['create']);
// Route::get('fabricacion/carga', [RegistroDeFabricacionController::class, 'loadProductionForm'])->name('fabricacion.loadProductionForm');


Route::resource('listado_de_entregas_productos',ListadoEntregaProductoController::class);