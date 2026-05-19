<?php

use App\Http\Controllers\PlatilloController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

    // 3. Ruta para el Cliente
    Route::get('/cliente/home', function () {
        return view('cliente.home');
    })->name('cliente.home');

    
     //Redirección inteligente de Breeze basada en Roles
    
    Route::get('/dashboard', function () {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('cliente.home');
    })->name('dashboard');

});

require __DIR__ . '/auth.php';