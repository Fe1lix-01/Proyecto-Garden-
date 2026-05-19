<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orden;

class CocinaController extends Controller
{
    public function index()
    {
        // Traemos las órdenes activos y cargamos la relación exacta 'detallesOrden'
        $ordenes = Orden::whereIn('estado', ['en espera', 'en_preparacion'])
                        ->with('detallesOrden.platillo')
                        ->get();
                        
        return view('cocina.index', compact('ordenes'));
    }

    public function marcarComoLista($id)
    {
        $orden = Orden::findOrFail($id);
        
        // Lógica de fases:
        if ($orden->estado === 'en espera') {
            // Si está en espera, pasa a preparación
            $orden->estado = 'en_preparacion';
        } elseif ($orden->estado === 'en_preparacion') {
            // Si ya se estaba preparando, pasa a terminada (completada)
            $orden->estado = 'completada';
        }
        
        $orden->save();

        return redirect()->route('cocina.index');
    }
}