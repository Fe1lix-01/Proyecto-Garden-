<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    protected $table = 'categorias';

    protected $fillable = [
        'categoria',
        'descripcion'
    ];

    public function platillos(): HasMany
    {
        return $this->hasMany(Platillo::class, 'categoria_id');
    }
}
