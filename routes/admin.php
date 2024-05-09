<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\MpIngresoController;
use App\Http\Controllers\MpSalidaController;
use App\Http\Controllers\ListadoOfController;
use App\Http\Controllers\ProductoCategoriaController;
use App\Http\Controllers\RegistroDeFabricacionController;
use App\Http\Controllers\ListadoEntregaProductoController;


// Rutas de autenticación
// Auth::routes();

// Agrupa todas las rutas que requieren autenticación
Route::middleware(['auth'])->group(function () {
    Route::get('admin', [HomeController::class, 'index'])->name('admin.index');

    // Agrega aquí todas las demás rutas que requieren autenticación
});

// Ruta de login (Si no usas el método Auth::routes())
// Asegúrate de tener una ruta definida para el login si no utilizas Auth::routes()

// Ruta de login para el administrador
Route::get('admin/login', [HomeController::class, 'showLoginForm'])->name('admin.login');

// Ruta de login general
Route::get('login', [HomeController::class, 'showLoginForm'])->name('general.login'); // Cambiado a 'general.login' para evitar conflictos


