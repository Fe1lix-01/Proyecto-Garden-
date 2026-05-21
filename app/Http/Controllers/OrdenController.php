<?php

namespace App\Http\Controllers;

use App\Models\Orden;
use Illuminate\Http\Request;
use App\Models\DetalleOrden;
use App\Models\Platillo;
use Illuminate\Support\Facades\DB;

class OrdenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Decodificamos el JSON que viene del campo 'items'
        $items = json_decode($request->items, true);

        if (empty($items)) {
            return back()->with('error', 'El carrito está vacío.');
        }

        // Usamos una Transacción de BD para que si algo falla, no se cree una orden incompleta
        return DB::transaction(function () use ($items) {
            
            // 2. Crear la cabecera de la Orden
            $orden = Orden::create([
                'user_id' => auth()->id(),
                'estado'  => 'pendiente',
                'total'   => 0, // Lo calcularemos sumando los detalles
            ]);

            $totalAcumulado = 0;

            // 3. Crear los detalles y congelar el precio
            foreach ($items as $item) {
                // BUSCAMOS EL PRECIO REAL EN LA BD (No confiamos en el JS)
                $platillo = Platillo::find($item['id']);
                
                if ($platillo) {
                    $subtotal = $platillo->precio * $item['cantidad'];
                    
                    DetalleOrden::create([
                        'orden_id'        => $orden->id,
                        'platillo_id'     => $platillo->id,
                        'cantidad'        => $item['cantidad'],
                        'precio_unitario' => $platillo->precio, // PRECIO CONGELADO
                        'subtotal'        => $subtotal,
                    ]);

                    $totalAcumulado += $subtotal;
                }
            }

            // 4. Actualizamos el total real de la orden
            $orden->update(['total' => $totalAcumulado]);

            return redirect()->route('cliente.home')
                   ->with('success', "Pedido #{$orden->id} realizado con éxito. Total: ${$totalAcumulado}");
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(orden $orden)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(orden $orden)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, orden $orden)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(orden $orden)
    {
        //
    }
}
