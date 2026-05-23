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
        // Traemos las órdenes del cliente, ordenadas de la más reciente a la más vieja
    $ordenes = Orden::where('user_id', auth()->id())
                    ->with('detallesOrden.platillo') // Con todo y los detalles de la Orden
                    ->orderBy('created_at', 'desc')
                    ->get();

    // Retornamos la vista del historial del cliente
    return view('cliente.mis_ordenes', compact('ordenes'));
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
        // Obtenemos los items del carrito desde el JSON enviado de la página
        $items = json_decode($request->items, true);

        if (empty($items)) {
            return back()->with('error', 'El carrito está vacío.');
        }

        // Usamos una Transacción por que si algo falla, no se cree una orden incompleta
        return DB::transaction(function () use ($items) {
            
            // Comienzo de la Orden
            $orden = Orden::create([
                'user_id' => auth()->id(),
                'estado'  => 'pendiente',
                'total'   => 0
            ]);

            $totalAcumulado = 0;

            // Creación de los detalles del pedido
            foreach ($items as $item) {
                // Se trae el platillo actual de la base de datos para asegurar que exista y obtener su precio actual
                $platillo = Platillo::find($item['id']);
                
                if ($platillo) {
                    $subtotal = $platillo->precio * $item['cantidad'];
                    
                    DetalleOrden::create([
                        'orden_id'    => $orden->id,
                        'platillo_id' => $platillo->id,
                        'cantidad'    => $item['cantidad'],
                        'precio'      => $platillo->precio,
                        'subtotal'    => $subtotal
                    ]);

                    $totalAcumulado += $subtotal;
                }
            }

            // 4. Actualizamos el total real de la orden
            $orden->update(['total' => $totalAcumulado]);

            // Reinicio del carrito despues de la compra exitosa
            session()->forget('carrito');

            return redirect()->route('cliente.home')
                   ->with('success', "Pedido #{$orden->id} realizado con éxito. Total: $" . number_format($totalAcumulado, 2));
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

    public function cancelarOrden($id)
    {
        // Buscamos la orden asegurando que pertenezca al cliente logueado
        $orden = Orden::where('user_id', auth()->id())->findOrFail($id);

        // Regla de negocio: Solo se puede cancelar si está pendiente o en espera
        if ($orden->estado === 'pendiente') {
            $orden->estado = 'cancelada';
            $orden->save();
            return redirect()->back()->with('success', 'Orden #' . $orden->id . ' cancelada correctamente.');
        }

        return redirect()->back()->with('error', 'No puedes cancelar una orden que ya está en preparación o lista.');
    }
}