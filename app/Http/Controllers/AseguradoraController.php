<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use App\Http\Resources\AseguradoraCollection;
use Illuminate\Http\Request;
use App\Models\Aseguradora;
class AseguradoraController extends Controller
{
    public function index(){
        //return response()->json(['aseguradoras' => Aseguradora::all()]);

        return new AseguradoraCollection(Aseguradora::all());
        
    }

    public function store(Request $request)
    {
        //validar la tarea con el request
        $this->validate($request, [
            'nombre' => ['required'],
            
        ],
        [
            'nombre.required' => 'El nombre de la aseguradora es obligatorio',
           
        ]);


  

        $aseguradora = new Aseguradora;
        $aseguradora->nombre = Str::upper($request->nombre); 
       
        $aseguradora->icono = Str::lower($request->nombre);
     
        $aseguradora->save();

        return [
            'id' => $aseguradora->id,
            'nombre' => $aseguradora->nombre,
            'icono' => $aseguradora->icono,
           
        ];
    }

}
