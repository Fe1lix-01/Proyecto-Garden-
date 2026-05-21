<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Platillo extends Model
{
    // Asignamos el nombre de la tabla a la clase modelo
    protected $table = 'platillos';

    public function detallesOrden(){
        return $this->hasMany(DetalleOrden::class, 'platillo_id');
    }

    public function categoria(){
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'disponible',
        'categoria_id'
    ];
}
