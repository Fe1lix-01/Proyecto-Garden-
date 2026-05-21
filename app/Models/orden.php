<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    // Asignamos el nombre de la tabla a la clase modelo
    protected $table = 'ordenes';

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function detallesOrden(){
        return $this->hasMany(DetalleOrden::class, 'orden_id');
    }

    protected $fillable = [
        'estado'
    ];
}
