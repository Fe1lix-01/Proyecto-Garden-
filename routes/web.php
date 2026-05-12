<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Ruta para el Panel del Cocinero
Route::get('/cocina', [App\Http\Controllers\CocinaController::class, 'index'])->name('cocina.index');
Route::post('/cocina/orden/{id}/lista', [App\Http\Controllers\CocinaController::class, 'marcarComoLista'])->name('cocina.marcarLista');
