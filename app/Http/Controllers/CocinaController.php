<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orden; // Asegúrate de tener este modelo creado

class CocinaController extends Controller
{
    public function index()
    {
        // Tu lógica para el Dashboard
        $ordenes = Orden::whereIn('estado', ['pendiente', 'en_preparacion'])->get();
        return view('cocina.index', compact('ordenes'));
    }
}