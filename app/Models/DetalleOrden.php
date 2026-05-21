<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleOrden extends Model
{
    // CORRECCIÓN: Quitamos la 's' para que coincida exactamente con phpMyAdmin
    protected $table = 'detalle_orden';

    public function orden(){
        return $this->belongsTo(Orden::class, 'orden_id');
    }

    public function platillo(){
        // Usamos Platillo::class con P mayúscula como tu modelo original
        return $this->belongsTo(Platillo::class, 'platillo_id');
    }

    // Mantenemos tus campos originales intactos
    protected $fillable = [
        'orden_id',
        'platillo_id',
        'cantidad',
        'precio',
        'subtotal'  
    ];
}
