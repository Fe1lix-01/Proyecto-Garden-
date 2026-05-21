<?php

use App\Http\Controllers\PlatilloController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route; 
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrdenController;
use App\Http\Controllers\CocinaController;


// Ruta de bienvenida
Route::get('/', function () {
    return view('welcome');
});


// Rutas protegidas por autenticación

Route::middleware(['auth', 'verified'])->group(function () {

    // 1. Perfil de usuario (común para ambos roles)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 2. Rutas para el Administrador / Staff
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard'); 
    })->name('admin.dashboard');

    // Ruta especial para cambiar la disponibilidad (Boolean) con un botón rápido
    Route::patch('/admin/platillos/{platillo}/toggle', [PlatilloController::class, 'toggleDisponibilidad'])
        ->name('admin.platillos.toggle');

    // Módulo CRUD de Platillos
    Route::resource('/admin/platillos', PlatilloController::class)
        ->names([
            'index'   => 'admin.platillos.index',
            'create'  => 'admin.platillos.create',
            'store'   => 'admin.platillos.store',
            'edit'    => 'admin.platillos.edit',
            'update'  => 'admin.platillos.update',
            'destroy' => 'admin.platillos.destroy',
        ])->except(['show']); // Excluimos 'show' porque no lo vamos a usar

    // Ruta para el Panel del Cocinero
    Route::get('/cocina', [CocinaController::class, 'index'])->name('cocina.index');
    Route::post('/cocina/orden/{id}/lista', [CocinaController::class, 'marcarComoLista'])->name('cocina.marcarLista');
    Route::put('/cocina/cancelar/{id}', [CocinaController::class, 'cancelarOrden'])->name('cocina.cancelar');

    // 3. Ruta para el Cliente
    Route::get('/cliente/home', [MenuController::class, 'index'])->name('cliente.home');

    Route::get('/cliente/carrito', function () {
        return view('cliente.carrito');
    })->name('cliente.carrito');

    Route::post('/ordenes/guardad', [OrdenController::class, 'store'])->name('ordenes.store');

     //Redirección inteligente de Breeze basada en Roles
    Route::get('/dashboard', function () {
    // Usamos la Facade Auth en lugar del helper auth()
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('cliente.home');
    })->name('dashboard');
});

require __DIR__.'/auth.php';


