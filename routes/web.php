<?php

use App\Http\Controllers\CarritoController;
use App\Http\Controllers\CocinaController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrdenController;
use App\Http\Controllers\PlatilloController;
use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('inicio');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Auth::user()->role === User::ROLE_COCINERO
            ? redirect()->route('cocina.ordenes.index')
            : redirect()->route('cliente.menu');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('role:cliente')
        ->prefix('cliente')
        ->name('cliente.')
        ->group(function () {
            Route::get('menu', [MenuController::class, 'index'])->name('menu');
            Route::get('carrito', [CarritoController::class, 'index'])->name('carrito');
            Route::post('carrito/agregar', [CarritoController::class, 'agregarAjax'])->name('carrito.agregar');
            Route::delete('carrito/{platillo}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');

            Route::get('ordenes', [OrdenController::class, 'index'])->name('ordenes.index');
            Route::post('ordenes', [OrdenController::class, 'store'])->name('ordenes.store');
            Route::patch('ordenes/{orden}/cancelar', [OrdenController::class, 'cancelarOrden'])->name('ordenes.cancelar');
        });

    Route::middleware('role:cocinero')
        ->prefix('cocina')
        ->name('cocina.')
        ->group(function () {
            Route::get('ordenes', [CocinaController::class, 'index'])->name('ordenes.index');
            Route::get('ordenes/{orden}', [CocinaController::class, 'show'])->name('ordenes.show');
            Route::patch('ordenes/{orden}/avanzar', [CocinaController::class, 'avanzarEstado'])->name('ordenes.avanzar');
            Route::patch('ordenes/{orden}/cancelar', [CocinaController::class, 'cancelarOrden'])->name('ordenes.cancelar');

            Route::patch('platillos/{platillo}/disponibilidad', [PlatilloController::class, 'toggleDisponibilidad'])
                ->name('platillos.disponibilidad');
            Route::resource('platillos', PlatilloController::class)
                ->except(['show'])
                ->names('platillos');
        });
});

require __DIR__.'/auth.php';
