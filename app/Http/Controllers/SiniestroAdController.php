<?php

namespace App\Http\Controllers;

use App\Http\Requests\SiniestroRequest;
use App\Http\Resources\AseguradoraCollection;
use App\Http\Resources\SiniestroAdCollection;
use App\Models\Aseguradora;
use App\Models\Siniestro;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiniestroAdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new SiniestroAdCollection(Siniestro::with('aseguradora')->with('user')->where('pagado', 0)->orderBy('id', 'DESC')->get());
    }

    public function siniestrosAll()
    {
        return new SiniestroAdCollection(Siniestro::with('aseguradora')->with('user')->where('pagado', 1)->orderBy('id', 'DESC')->paginate(10));
    }
    /**
     * muestra un registro buscandolo por su nombre.
     */
    public function unSiniestro($nombre)
    {

        $siniestro = Siniestro::with('aseguradora')->with('user')->where('nombre', $nombre)->first();
       
        return $siniestro;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SiniestroRequest $request)
    {
        
        //validar el siniestro con el request SiniestroRequest
        $siniestro = $request->validated();
        
        //Almacenar un siniestro
        
        $siniestro = new Siniestro;
        $siniestro->user_id = (int)$request->user_id;
        $siniestro->nombre = $request->nombre;
        $siniestro->marca = $request->marca;
        $siniestro->modelo = $request->modelo;
        $siniestro->serie = $request->serie;
        $siniestro->placas = $request->placas;
        $siniestro->aseguradora_id = (int)$request->aseguradora_id;
        // $siniestro->save();

        $aseguradora = new AseguradoraCollection(Aseguradora::where("Aseguradora_id", (int)$request->aseguradora_id));
        $user = $siniestro->user('id', $request->user_id );
        
        return [
            'id' => $siniestro->id,
            'nombre' => $siniestro->nombre,
            'aseguradora_id' => $siniestro->aseguradora_id,
            'marca' => $siniestro->marca,
            'modelo' => $siniestro->modelo,
            'serie' => $siniestro->serie,
            'placas' => $siniestro->placas,
            'user_id' => $siniestro->user_id,
            'aseguradora'=> $aseguradora,
            'user'=> $user
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Siniestro $siniestro)
    {
            $this->validate(
                $request,
                [
                    'nombre' => ['required', 'string', 'unique:siniestros,nombre,' . $siniestro->id],
                    'aseguradora_id' => 'required',
                ],
                [
                    'nombre.required' => 'El nombre o número del siniestro es obligatorio',
                    'nombre.unique' => 'El siniestro ya esta Registrado',
                    'aseguradora_id' => 'Seleccione una aseguradora de la lista',
                ]

            );

            $siniestro->nombre = $request->nombre;
            $siniestro->marca = $request->marca ?? null;
            $siniestro->modelo = $request->modelo ?? null;
            $siniestro->serie = $request->serie?? null;
            $siniestro->placas = $request->placas ?? null;
            $siniestro->aseguradora_id = $request->aseguradora_id;
            $siniestro->save();

            

            return $siniestro;
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function reporte(Request $request, Siniestro $siniestro)
    {
         $user = new User;
         $user = Auth::user();
            if($user->admin){

                $siniestro->reporte = $request->reporte;
                $siniestro->save();
            }

        return [
             'id' => $siniestro->id,
             'reporte' => $siniestro->reporte
             
           // 'request'=>$request->pagado
        ];
    }

}
