<?php

use App\Http\Controllers\PlatilloController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route; 
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrdenController;
use App\Http\Controllers\CocinaController;

// 1. Importas tu middleware directamente aquí arriba
use App\Http\Middleware\RoleMiddleware; 

// Ruta de bienvenida
Route::get('/', function () {
    return view('welcome');
});

// Rutas protegidas por autenticación general (Breeze)
Route::middleware(['auth', 'verified'])->group(function () {

    // Perfil de usuario (Común para ambos)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas del ADMINISTRADOR (Usando la clase directamente + el parámetro 'admin')
    Route::middleware([RoleMiddleware::class . ':admin'])->group(function () {
        
        Route::get('/admin/dashboard', function () {
            return view('admin.dashboard'); 
        })->name('admin.dashboard');

        Route::patch('/admin/platillos/{platillo}/toggle', [PlatilloController::class, 'toggleDisponibilidad'])
            ->name('admin.platillos.toggle');

        Route::resource('/admin/platillos', PlatilloController::class)
            ->names([
                'index'   => 'admin.platillos.index',
                'create'  => 'admin.platillos.create',
                'store'   => 'admin.platillos.store',
                'edit'    => 'admin.platillos.edit',
                'update'  => 'admin.platillos.update',
                'destroy' => 'admin.platillos.destroy',
            ])->except(['show']);

        // Sección de cocina
        Route::get('/cocina', [CocinaController::class, 'index'])->name('cocina.index');
        Route::post('/cocina/orden/{id}/lista', [CocinaController::class, 'marcarComoLista'])->name('cocina.marcarLista');
    });

    // Rutas del CLIENTE (Usando la clase directamente + el parámetro 'cliente')
    Route::middleware([RoleMiddleware::class . ':cliente'])->group(function () {
        
        Route::get('/cliente/home', [MenuController::class, 'index'])->name('cliente.home');

        Route::get('/cliente/carrito', function () {
            return view('cliente.carrito');
        })->name('cliente.carrito');

        Route::post('/ordenes/guardad', [OrdenController::class, 'store'])->name('ordenes.store');
    });

    // Redirección inteligente de Breeze basada en Roles
    Route::get('/dashboard', function () {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('cliente.home');
    })->name('dashboard');
});

require __DIR__.'/auth.php';