<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;
     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'fecha_pago',
        'monto',
        'iva',
        'pago_verificador',
        'total',
        'siniestro_id',
    ];

    public function siniestro()
    {
        return $this->belongsTo(Siniestro::class);
    }
}
