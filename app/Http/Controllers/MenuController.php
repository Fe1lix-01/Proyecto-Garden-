<?php

namespace App\Http\Controllers;

use App\Models\Categoria; 
use Illuminate\View\View;

class MenuController extends Controller
{
    public function index(): View
    {
        $categorias = Categoria::with(['platillos' => function ($query) {
            $query->where('disponible', true)->orderBy('nombre');
        }])
            ->whereHas('platillos', fn ($query) => $query->where('disponible', true))
            ->orderBy('id')
            ->get();

        return view('cliente.menu_platillos', compact('categorias'));
    }
}
