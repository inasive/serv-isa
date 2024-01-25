<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use App\Http\Resources\TareaCollection;
use App\Models\Siniestro;
use Illuminate\Http\Request;

class TareaController extends Controller
{


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validar la tarea con el request
        $this->validate($request, [
            'nombre' => ['required']
        ]);


        if($request->notificacion !== null){

            $siniestro = Siniestro::find($request->siniestro_id);
            $siniestro->notificacion = $request->notificacion;
            $siniestro->save();

            }

        $tarea = new Tarea;
        $tarea->nombre = $request->nombre;
        $tarea->siniestro_id = $request->siniestro_id;
        $tarea->admin = $request->admin;
        $tarea->estado = 0;
        $tarea->save();

        return [
            'id' => $tarea->id,
            'nombre' => $tarea->nombre,
            'estado' => $tarea->estado,
            'siniestro_id' => $tarea->siniestro_id,
            'admin'=> $tarea->admin
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Tarea $tarea)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tarea $tarea)
    {
     
            $this->validate(
                $request,
                [
                    'nombre' => ['required', 'string'],

                ],
                [
                    'nombre.required' => 'El nombre de la tarea es obligatorio',
                ]

            );

            $tarea->nombre = $request->nombre;
            $tarea->estado = $request->estado;
            $tarea->save();

            return $tarea;
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tarea $tarea)
    {
        $tarea = Tarea::find($tarea->id); //Se encuentra el registro. 
      
        $tarea->delete();

        return [
            'status'=> 200,
            'delete'=> 'ok'
        ];
    }
}
