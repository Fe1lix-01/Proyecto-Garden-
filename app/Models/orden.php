<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    // Asignamos el nombre de la tabla a la clase modelo
    protected $table = 'ordenes';

    /**
     * Relación: Una orden pertenece a un usuario (cliente)
     */
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relación: Una orden tiene muchos detalles (platillos pedidos)
     */
    public function detallesOrden(){
        return $this->hasMany(DetalleOrden::class, 'orden_id');
    }

    /**
     * Campos autorizados para asignación masiva (Mass Assignment)
     * CORREGIDO: Se agregaron 'user_id' y 'total' para permitir su inserción desde el controlador
     */
    protected $fillable = [
        'user_id',
        'total',
        'estado'
    ];
}