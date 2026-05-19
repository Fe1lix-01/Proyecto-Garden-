
<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; 
use App\Http\Controllers\MenuController;


Route::get('/', function () {
    return view('welcome');
});

// Rutas protegidas por autenticación
Route::middleware(['auth', 'verified'])->group(function () {

    // 1. Perfil de usuario (común para ambos roles)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 2. Ruta para el Administrador / Staff del restaurante
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard'); 
    })->name('admin.dashboard');

    // 3. Ruta para el Cliente
    Route::get('/cliente/home', [MenuController::class, 'index'])->name('cliente.home');

    Route::get('/cliente/carrito', function () {
        return view('cliente.carrito');
    })->name('cliente.carrito');

    Route::post('/ordenes/guardad', [OrdenController::class, 'store'])->name('ordenes.store');


    /**
     * NOTA: Mantenemos esta ruta 'dashboard' genérica por si algún componente 
     * de Breeze la busca, pero la lógica de redirección real ya la pusiste 
     * en AuthenticatedSessionController.
     */
    Route::get('/dashboard', function () {
    // Usamos la Facade Auth en lugar del helper auth()
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('cliente.home');
    })->name('dashboard');
});

require __DIR__.'/auth.php';

// Ruta para el Panel del Cocinero
Route::get('/cocina', [App\Http\Controllers\CocinaController::class, 'index'])->name('cocina.index');
Route::post('/cocina/orden/{id}/lista', [App\Http\Controllers\CocinaController::class, 'marcarComoLista'])->name('cocina.marcarLista');

