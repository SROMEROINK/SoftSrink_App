<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\ProductoController;

// Ruta por defecto al iniciar la app
Route::get('/', function () {
    return view('welcome');
})->name('welcome');


// Rutas de autenticación
Auth::routes();

// Rutas hacia el HomeController
//Route::get('/home', [AdminHomeController::class, 'index'])->name('adminHome');
//Route::get('/admin', [AdminHomeController::class, 'index'])->name('admin.index');



// Agrupa todas las rutas que requieren autenticación
Route::middleware(['auth'])->group(function () {
    Route::get('admin', [HomeController::class, 'index'])->name('admin.index');
    Route::resource('admin/productos', ProductoController::class)->names('admin.products');

    
    // Agrega aquí todas las demás rutas que requieren autenticación
});

// Ruta de login (Si no usas el método Auth::routes())
// Asegúrate de tener una ruta definida para el login si no utilizas Auth::routes()
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');

// Ruta hacia el HomeController dentro de Admin
Route::get('admin', [HomeController::class, 'index'])->name('admin.index');

// Rutas para el CRUD de productos en el área de administración
Route::resource('admin/productos', ProductoController::class)->names('admin.products');

// Asegúrate de ajustar las rutas y sus nombres según la estructura que prefieras.


Route::resource('mp_ingresos', MpIngresoController::class)->names([
    'index' => 'mp_ingresos.index']);







