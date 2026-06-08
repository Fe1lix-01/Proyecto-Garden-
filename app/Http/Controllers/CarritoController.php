<?php

namespace App\Http\Controllers;

use App\Models\Platillo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CarritoController extends Controller
{
    public function index(): View
    {
        return view('cliente.carrito', [
            'carrito' => session('carrito', []),
        ]);
    }

    public function agregarAjax(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'platillo_id' => ['required', 'exists:platillos,id'],
            'cantidad' => ['required', 'integer', 'min:1', 'max:20'],
        ]);

        $platillo = Platillo::where('disponible', true)->findOrFail($validated['platillo_id']);
        $cantidad = (int) $validated['cantidad'];
        $carrito = session()->get('carrito', []);

        if (isset($carrito[$platillo->id])) {
            $carrito[$platillo->id]['cantidad'] += $cantidad;
            $carrito[$platillo->id]['imagen'] = $platillo->imagen;
        } else {
            $carrito[$platillo->id] = [
                'id' => $platillo->id,
                'nombre' => $platillo->nombre,
                'cantidad' => $cantidad,
                'precio' => (float) $platillo->precio,
                'imagen' => $platillo->imagen,
            ];
        }

        session()->put('carrito', $carrito);

        return response()->json([
            'success' => true,
            'totalItems' => collect($carrito)->sum('cantidad'),
            'message' => "{$platillo->nombre} agregado al carrito.",
        ]);
    }

    public function eliminar(Platillo $platillo): RedirectResponse
    {
        $carrito = session()->get('carrito', []);

        if (isset($carrito[$platillo->id])) {
            unset($carrito[$platillo->id]);
            session()->put('carrito', $carrito);
        }

        return redirect()->route('cliente.carrito')->with('success', 'Platillo eliminado del carrito.');
    }
}
