<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orden;

class CocinaController extends Controller
{
    /**
     * El método index ya no es estrictamente necesario porque la lógica 
     * se movió directamente a las rutas, pero lo dejamos apuntando al dashboard 
     * con la consulta correcta por si acaso alguna barra de navegación lo llama.
     */
    public function index()
    {
        $ordenes = Orden::whereIn('estado', ['en espera', 'en_preparacion'])
                        ->with('detallesOrden.platillo')
                        ->get();
                        
        return view('admin.dashboard', compact('ordenes'));
    }

    /**
     * Cambia el estado de la orden de "en espera" -> "en_preparacion" -> "completada"
     */
    public function marcarComoLista($id)
    {
        $orden = Orden::findOrFail($id);
        
        // Lógica de fases de la cocina:
        if ($orden->estado === 'en espera') {
            // Si está en espera, pasa a preparación
            $orden->estado = 'en_preparacion';
        } elseif ($orden->estado === 'en_preparacion') {
            // Si ya se estaba preparando, pasa a completada
            $orden->estado = 'completada';
        }
        
        $orden->save();

        // CORREGIDO: Redirecciona al panel unificado de administración
        return redirect()->route('admin.dashboard')->with('success', 'El estado del pedido #' . $orden->id . ' ha sido actualizado.');
    }

    /**
     * Cancela la orden directamente desde el monitor de cocina
     */
    public function cancelarOrden($id)
    {
        $orden = Orden::findOrFail($id);
        
        // Cambiamos el estado a cancelado
        $orden->estado = 'cancelada';
        $orden->save();

        // CORREGIDO: Redirecciona al panel unificado de administración
        return redirect()->route('admin.dashboard')->with('success', 'El pedido #' . $orden->id . ' fue cancelado correctamente.');
    }
}