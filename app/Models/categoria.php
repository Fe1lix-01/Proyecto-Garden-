<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    // Asignamos el nombre de la tabla a la clase modelo
    protected $table = 'categorias';

    public function platillos(){
        return $this->hasMany(Platillo::class, 'categoria_id');
    }

    // Solo se permitira agregar la descripcion de la categoria, el id se asignara 
    // automaticamente al momento de crear la categoria
    protected $fillable = [
        'categoria',
        'descripcion'
    ];
}
