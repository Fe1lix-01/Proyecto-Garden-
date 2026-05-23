<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Platillo;

class CarritoController extends Controller
{
    public function agregarAjax(Request $request)
    {
        // Validación de que el platillo realmente exista en la base de datos
        $platillo = Platillo::findOrFail($request->platillo_id);
        
        // Obtiene el carrito actual de la sesión (si no existe, inicia vacío)
        $carrito = session()->get('carrito', []);

        // Si el platillo ya estaba, sumamos la cantidad. Si no, lo agregamos.
        if(isset($carrito[$platillo->id])) {
            $carrito[$platillo->id]['cantidad'] += (int)$request->cantidad;
        } else {
            $carrito[$platillo->id] = [
                "id" => $platillo->id,
                "nombre" => $platillo->nombre,
                "cantidad" => (int)$request->cantidad,
                "precio" => $platillo->precio
            ];
        }

        // Guarda el carrito actualizado en la sesión
        session()->put('carrito', $carrito);

        // Contar el total de ítems acumulados para el círculo del Navbar
        $totalItems = collect($carrito)->sum('cantidad');

        // Respuesta a JavaScript con el éxito y el nuevo número total
        return response()->json([
            'success' => true,
            'totalItems' => $totalItems
        ]);
    }

    public function eliminar($id)
{
    // Obtenemos el carrito actual de la sesión
    $carrito = session()->get('carrito', []);

    // Si el platillo existe en el carrito, lo removemos
    if (isset($carrito[$id])) {
        unset($carrito[$id]);
        session()->put('carrito', $carrito);
    }

    // Redireccionamos de vuelta a la pantalla del carrito actualizada
    return redirect()->back();
}
}