<?php

namespace App\Http\Controllers;

use App\Http\Resources\TareaCollection;
use App\Models\Siniestro;
use App\Models\Tarea;
use Illuminate\Http\Request;

class TareasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Siniestro $siniestro)
    {
        $tareas = Tarea::where('siniestro_id', $siniestro->id)
        ->orderBy('created_at', 'DESC')
        ->get()
        ->groupBy(function ($item) {
            return  $item->created_at->format('Y-m-d'); // Agrupa por fecha (año-mes-día)
        });

    return $tareas;
        // return new TareaCollection(Tarea::where('siniestro_id', $siniestro->id)->orderBy('id', 'DESC')->get());
    }
}
