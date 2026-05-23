<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleOrden extends Model
{
    // CORRECCIÓN: Apunta directamente al nombre exacto de tu tabla en la base de datos
    protected $table = 'detalle_orden';

    /**
     * Relación: Un detalle pertenece a una orden principal
     */
    public function orden(){
        return $this->belongsTo(Orden::class, 'orden_id');
    }

    /**
     * Relación: Un detalle corresponde a un platillo específico del menú
     */
    public function platillo(){
        return $this->belongsTo(Platillo::class, 'platillo_id');
    }

    /**
     * Campos autorizados para la asignación masiva (Mass Assignment)
     * Permite registrar los renglones del pedido desde el bucle del controlador
     */
    protected $fillable = [
        'orden_id',
        'platillo_id',
        'cantidad',
        'precio',
        'subtotal'  
    ];
}