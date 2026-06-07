<?php

namespace App\Http\Controllers;

use App\Models\DetalleOrden;
use App\Models\Orden;
use App\Models\Platillo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OrdenController extends Controller
{
    public function index(): View
    {
        $ordenes = Orden::where('user_id', auth()->id())
            ->with('detalles.platillo')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('cliente.historial_ordenes', compact('ordenes'));
    }

    public function store(): RedirectResponse
    {
        $carrito = session('carrito', []);

        if (empty($carrito)) {
            return redirect()
                ->route('cliente.carrito')
                ->with('error', 'El carrito esta vacio.');
        }

        $detalles = [];
        $total = 0;

        foreach ($carrito as $item) {
            $platillo = Platillo::where('disponible', true)->find($item['id'] ?? null);
            $cantidad = max(1, (int) ($item['cantidad'] ?? 0));

            if (! $platillo || $cantidad < 1) {
                continue;
            }

            $precioUnitario = (float) $platillo->precio;
            $subtotal = $precioUnitario * $cantidad;
            $total += $subtotal;

            $detalles[] = [
                'platillo' => $platillo,
                'cantidad' => $cantidad,
                'precio_unitario' => $precioUnitario,
                'subtotal' => $subtotal,
            ];
        }

        if (empty($detalles)) {
            session()->forget('carrito');

            return redirect()
                ->route('cliente.menu')
                ->with('error', 'Los platillos del carrito ya no estan disponibles.');
        }

        $orden = DB::transaction(function () use ($detalles, $total) {
            $orden = Orden::create([
                'user_id' => auth()->id(),
                'estado' => Orden::ESTADO_PENDIENTE,
                'total' => $total,
            ]);

            foreach ($detalles as $detalle) {
                DetalleOrden::create([
                    'orden_id' => $orden->id,
                    'platillo_id' => $detalle['platillo']->id,
                    'cantidad' => $detalle['cantidad'],
                    'precio_unitario' => $detalle['precio_unitario'],
                    'subtotal' => $detalle['subtotal'],
                ]);
            }

            return $orden;
        });

        session()->forget('carrito');

        return redirect()
            ->route('cliente.ordenes.index')
            ->with('success', 'Orden #' . $orden->id . ' creada correctamente. Total: $' . number_format($total, 2));
    }

    public function cancelarOrden(Orden $orden): RedirectResponse
    {
        abort_if($orden->user_id !== auth()->id(), 403);

        if (! $orden->puedeCancelarse()) {
            return redirect()
                ->route('cliente.ordenes.index')
                ->with('error', 'Solo puedes cancelar ordenes pendientes.');
        }

        $orden->update(['estado' => Orden::ESTADO_CANCELADA]);

        return redirect()
            ->route('cliente.ordenes.index')
            ->with('success', 'Orden #' . $orden->id . ' cancelada correctamente.');
    }
}
