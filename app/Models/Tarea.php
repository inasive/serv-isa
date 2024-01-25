<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    use HasFactory;
     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'nombre',
        'estado',
        'siniestro_id',
        'admin',
    ];
    public function siniestro()
    {
        return $this->belongsTo(Siniestro::class);
    
    }

}
