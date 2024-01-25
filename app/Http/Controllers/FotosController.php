<?php

namespace App\Http\Controllers;

use App\Http\Resources\FotoCollection;
use App\Models\Foto;
use App\Models\Siniestro;
use Illuminate\Http\Request;

class FotosController extends Controller
{
    public function index(Siniestro $siniestro)
    {
       
        return new FotoCollection(Foto::where('siniestro_id', $siniestro->id)->get());
       
    }
}
