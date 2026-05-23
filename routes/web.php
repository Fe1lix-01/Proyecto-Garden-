<?php

use App\Http\Controllers\PlatilloController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route; 
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrdenController;
use App\Http\Controllers\CocinaController;
use App\Http\Controllers\CarritoController; // <-- Importación agregada para el carrito
use App\Http\Middleware\RoleMiddleware; 
use App\Models\Orden;

// Ruta de bienvenida
Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {

    // Perfil de usuario (Común para todos los usuarios logueados)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ------------------------------------------
    // ROLES: ADMINISTRADOR
    // ------------------------------------------
    Route::middleware([RoleMiddleware::class . ':admin'])->group(function () {
        
        // Carga los pedidos activos para la cocina unificada antes de renderizar la vista
        Route::get('/admin/dashboard', function () {
            $ordenes = Orden::whereIn('estado', ['pendiente', 'en_preparacion'])
                            ->with('detallesOrden.platillo')
                            ->orderBy('created_at', 'asc')
                            ->get();

            return view('admin.dashboard', compact('ordenes')); 
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
    
        // Rutas de procesamiento de cocina
        Route::post('/cocina/orden/{id}/lista', [CocinaController::class, 'marcarComoLista'])->name('cocina.marcarLista');
        Route::put('/cocina/cancelar/{id}', [CocinaController::class, 'cancelarOrden'])->name('cocina.cancelar');
    });

    // ------------------------------------------
    // ROLES: CLIENTE
    // ------------------------------------------
    Route::middleware([RoleMiddleware::class . ':cliente'])->group(function () {
        
        Route::get('/cliente/home', [MenuController::class, 'index'])->name('cliente.home');

        // CORREGIDO: llave de cierre del callback agregada correctamente
        Route::get('/cliente/carrito', function () {
            return view('cliente.carrito');
        })->name('cliente.carrito');

        // Ruta interactiva para agregar productos al carrito sin recargar pantalla (AJAX)
        Route::post('/carrito/agregar-ajax', [CarritoController::class, 'agregarAjax'])->name('carrito.agregar.ajax');

        // Ruta para poder eliminar un platillo del carrito desde la vista de confirmación
        Route::delete('/carrito/eliminar/{id}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');

        // Guardar la orden final
        Route::post('/ordenes/guardar', [OrdenController::class, 'store'])->name('ordenes.store');

        // Historial de órdenes
        Route::get('/cliente/ordenes', [OrdenController::class, 'index'])->name('cliente.ordenes');
        Route::post('/cliente/ordenes/{id}/cancelar', [OrdenController::class, 'cancelarOrden'])->name('cliente.ordenes.cancelar');
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