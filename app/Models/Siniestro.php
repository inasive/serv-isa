<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Siniestro extends Model
{
    use HasFactory, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'nombre',
        'marca',
        'modelo',
        'serie',
        'placas',
        'terminado',
        'notificacion',
        'pagado',
        'aseguradora_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->select(['id','name', 'email', 'telefono']);
    }
    public function aseguradora()
    {
        return $this->belongsTo(Aseguradora::class);
    }

    public function foto()
    {
        return $this->hasMany(Foto::class);
    }
    public function tarea()
    {
        return $this->hasMany(Tarea::class);
    }

    public function pago()
    {
        return $this->belongsTo(Pago::class);
    }
    public function administrador()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
 
}
