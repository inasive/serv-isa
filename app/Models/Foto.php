<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foto extends Model
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
        'url',
        'descripcion',
        'siniestro_id',
    ];
    
    public function siniestro()
    {
        return $this->belongsTo(Siniestro::class);
    
    }
};
