<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria; 

class MenuController extends Controller
{
    public function index()
    {
        // 1. Traemos las categorías.
        // 2. Traemos sus platillos, pero le ponemos la condición de que 'disponible' sea true (1).
        $categorias = Categoria::with(['platillos' => function ($query) {
            $query->where('disponible', true);
        }])->get();

        // 3. Le mandamos esta información a la vista
        return view('cliente.home', compact('categorias'));
    }
}