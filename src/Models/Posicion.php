<?php

namespace Cirote\Movimientos\Models;

use Illuminate\Database\Eloquent\Model;
use Cirote\Activos\Config\Config;
use Cirote\Activos\Models\Activo;
use App\Models\Broker;

class Posicion extends Model
{
    protected $table = Config::PREFIJO . Config::POSICIONES;

    protected $guarded = [];

    protected $dates = [
        'fecha_apertura',
        'fecha_cierre'
    ];

    public function Activo()
    {
        return $this->belongsTo(Activo::class);
    }

    public function Broker()
    {
        return $this->belongsTo(Broker::class);
    }

    public function Movimientos()
    {
        return $this->belongsToMany(Movimiento::class, Config::PREFIJO . Config::MOVIMIENTOS_POSICIONES)
            ->as('asignado');
    }

    public function scopeAbiertas($query)
    {
        $query->where('estado', 'Abierta');
    }

    public function scopeCerradas($query)
    {
        $query->where('estado', 'Cerrada');
    }

    public function scopeCortas($query)
    {
        $query->where('tipo', 'Corta');
    }

    public function scopeLargas($query)
    {
        $query->where('tipo', 'Larga');
    }

    public function scopeByActivo($query, Activo $activo)
    {
        $query->where('activo_id', $activo->id);
    }

    public function scopeByBroker($query, Broker $broker)
    {
        $query->where('broker_id', $broker->id);
    }

    public function scopeOrdenadas($query)
    {
        $query->orderBy('fecha_apertura');
    }

    public function scopeResumir($query)
    {
        $query->selectRaw('activo_id, sum(cantidad) as cantidad, sum(cantidad * precio_en_dolares) as precioXcantidad, max(tipo) as tipo, max(precio_en_dolares) as mayor_precio_en_dolares, min(precio_en_dolares) as menor_precio_en_dolares, sum(monto_en_dolares) as monto_total_en_dolares')
            ->groupBy('activo_id');
    }
}
