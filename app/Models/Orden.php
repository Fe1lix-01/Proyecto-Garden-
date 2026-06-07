<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Orden extends Model
{
    public const ESTADO_PENDIENTE = 'pendiente';
    public const ESTADO_EN_PREPARACION = 'en_preparacion';
    public const ESTADO_LISTA = 'lista';
    public const ESTADO_CANCELADA = 'cancelada';

    protected $table = 'ordenes';

    protected $fillable = [
        'user_id',
        'total',
        'estado',
    ];

    protected $casts = [
        'total' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function detalles(): HasMany
    {
        return $this->hasMany(DetalleOrden::class, 'orden_id');
    }

    public function detallesOrden(): HasMany
    {
        return $this->detalles();
    }

    public function puedeAvanzar(): bool
    {
        return in_array($this->estado, [self::ESTADO_PENDIENTE, self::ESTADO_EN_PREPARACION], true);
    }

    public function siguienteEstado(): ?string
    {
        return match ($this->estado) {
            self::ESTADO_PENDIENTE => self::ESTADO_EN_PREPARACION,
            self::ESTADO_EN_PREPARACION => self::ESTADO_LISTA,
            default => null,
        };
    }

    public function puedeCancelarse(): bool
    {
        return $this->estado === self::ESTADO_PENDIENTE;
    }
}
