<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleOrden extends Model
{
<<<<<<< HEAD
    // Asignamos el nombre de la tabla a la clase modelo
    protected $table = 'detalles_ordenes';
=======
    // CORRECCIÓN: Quitamos la 's' para que coincida exactamente con phpMyAdmin
    protected $table = 'detalle_orden';
>>>>>>> rediseño-panel-cocina

    public function orden(){
        return $this->belongsTo(Orden::class, 'orden_id');
    }

    public function platillo(){
<<<<<<< HEAD
        return $this->belongsTo(Platillo::class, 'platillo_id');
    }

    // Solo se permitira agregar el id del platillo y la cantidad, el id de la orden se 
    // asignara automaticamente al momento de crear el detalle de orden
=======
        // Usamos Platillo::class con P mayúscula como tu modelo original
        return $this->belongsTo(Platillo::class, 'platillo_id');
    }

    // Mantenemos tus campos originales intactos
>>>>>>> rediseño-panel-cocina
    protected $fillable = [
        'orden_id',
        'platillo_id',
        'cantidad',
        'precio_unitario',
        'subtotal'  
    ];
}
