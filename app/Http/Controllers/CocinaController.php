<?php

namespace App\Http\Controllers;

use App\Models\Orden;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CocinaController extends Controller
{
    public function index(Request $request): View
    {
        $filtro = $request->query('estado', 'activas');
        $filtrosValidos = ['activas', 'pendiente', 'en_preparacion', 'lista', 'cancelada', 'todas'];

        if (! in_array($filtro, $filtrosValidos, true)) {
            $filtro = 'activas';
        }

        $query = Orden::with(['user', 'detalles.platillo'])
            ->orderBy('created_at', 'asc');

        match ($filtro) {
            'activas' => $query->whereIn('estado', [Orden::ESTADO_PENDIENTE, Orden::ESTADO_EN_PREPARACION]),
            'todas' => null,
            default => $query->where('estado', $filtro),
        };

        $ordenes = $query->get();
        $conteos = [
            'pendiente' => Orden::where('estado', Orden::ESTADO_PENDIENTE)->count(),
            'en_preparacion' => Orden::where('estado', Orden::ESTADO_EN_PREPARACION)->count(),
            'lista' => Orden::where('estado', Orden::ESTADO_LISTA)->count(),
            'cancelada' => Orden::where('estado', Orden::ESTADO_CANCELADA)->count(),
        ];

        return view('cocina.ordenes.index', compact('ordenes', 'filtro', 'conteos'));
    }

    public function show(Orden $orden): View
    {
        $orden->load(['user', 'detalles.platillo']);

        return view('cocina.ordenes.show', compact('orden'));
    }

    public function avanzarEstado(Orden $orden): RedirectResponse
    {
        if (! $orden->puedeAvanzar()) {
            return redirect()
                ->route('cocina.ordenes.index')
                ->with('error', 'Esta orden ya no puede cambiar de estado.');
        }

        $orden->update(['estado' => $orden->siguienteEstado()]);

        return redirect()
            ->route('cocina.ordenes.index')
            ->with('success', 'Estado de la orden #' . $orden->id . ' actualizado.');
    }

    public function cancelarOrden(Orden $orden): RedirectResponse
    {
        if (! $orden->puedeCancelarse()) {
            return redirect()
                ->route('cocina.ordenes.index')
                ->with('error', 'Solo se pueden cancelar ordenes pendientes.');
        }

        $orden->update(['estado' => Orden::ESTADO_CANCELADA]);

        return redirect()
            ->route('cocina.ordenes.index')
            ->with('success', 'Orden #' . $orden->id . ' cancelada correctamente.');
    }
}
