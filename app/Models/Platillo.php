<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Platillo extends Model
{
    protected $table = 'platillos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'disponible',
        'imagen',
        'categoria_id'
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'disponible' => 'boolean',
    ];

    public function detalles(): HasMany
    {
        return $this->hasMany(DetalleOrden::class, 'platillo_id');
    }

    public function detallesOrden(): HasMany
    {
        return $this->detalles();
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }
}
