<?php

namespace App\Http\Controllers;

use App\Http\Requests\SiniestroRequest;
use App\Models\Siniestro;
use App\Http\Resources\SiniestroCollection;
use App\Models\Aseguradora;
use App\Models\User;
use App\Notifications\SiniestroTerminado;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class SiniestroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // return new SiniestroCollection(Siniestro::where('user_id', Auth::user()->id)->where('terminado', 0)->orderBy('id', 'DESC')->get());
        // return new SiniestroCollection(
        //     Siniestro::where('user_id', Auth::user()->id)
        //         ->where('terminado', 0)
        //         ->withCount(['tarea as tarea_count' => function ($query) {
        //             $query->whereNotNull('admin')->where('estado', 0);
        //         }])->orderBy('id', 'DESC')->get()
        // );

        $userId = auth()->user()->id;

        $siniestros = Siniestro::where('user_id', $userId)
            ->where('terminado', 0)
            ->withCount(['tarea as tarea_count' => function ($query) {
                $query->whereNotNull('admin')->where('estado', 0);
            }])
            ->orderBy('id', 'DESC')
            ->get();

        return response()->json($siniestros);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(SiniestroRequest $request)
    {

        //validar el siniestro con el request SiniestroRequest
        $data = $request->validated();

        return $request;

        $siniestro = new Siniestro;

        //Almacenar el siniestro
        if ($request->user_id) {

            $siniestro->user_id = $request->user_id;
        } else {

            $siniestro->user_id = Auth::user()->id;
        }

        $siniestro->nombre = $request->nombre;
        $siniestro->marca = $request->marca;
        $siniestro->modelo = $request->modelo;
        $siniestro->serie = $request->serie;
        $siniestro->placas = $request->placas;
        $siniestro->aseguradora_id = (int)$request->aseguradora_id;
        $siniestro->notificacion = json_encode(["num" => "1", "Fecha" => Carbon::now(), "time" => $request->time]);

        $siniestro->save();

        return [
            'id' => $siniestro->id,
            'nombre' => $siniestro->nombre,
            'aseguradora_id' => $siniestro->aseguradora_id,
            'marca' => $siniestro->marca,
            'modelo' => $siniestro->modelo,
            'serie' => $siniestro->serie,
            'placas' => $siniestro->placas,
            'user_id' => $siniestro->user_id,

        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Siniestro $siniestro)
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
                'aseguradora_id' => 'Seleccione una aseguradora_id de la lista',
            ]

        );

        if ($request->user_id) {

            // $user = new User;
            // [$user] = User::where('id', $request->user_id)->get();
            // $aseguradora = new Aseguradora;
            // [$aseguradora] = Aseguradora::where('id', $request->aseguradora_id)->get();

            $siniestro->aseguradora_id = $request->aseguradora_id;
            $siniestro->marca = $request->marca;
            $siniestro->modelo = $request->modelo;
            $siniestro->nombre = $request->nombre;
            $siniestro->notificacion = $request->notificacion;
            $siniestro->placas = $request->placas;
            $siniestro->serie = $request->serie;
            $siniestro->user_id = $request->user_id;

            $siniestro->save();


            return [

                'status' => 200,
                'cambios' => 'ok'
            ];
        }

        $siniestro->aseguradora_id = $request->aseguradora_id;
        $siniestro->marca = $request->marca;
        $siniestro->modelo = $request->modelo;
        $siniestro->nombre = $request->nombre;
        $siniestro->serie = $request->serie;
        $siniestro->placas = $request->placas;
        $siniestro->terminado = $request->terminado;
        $siniestro->save();


        return [

            'aseguradora_id' => $siniestro->asegurador_id,
            'marca' => $siniestro->marca,
            'modelo' => $siniestro->modelo,
            'nombre' => $siniestro->nombre,
            'notificacion' => $siniestro->notificacion,
            'placas' => $siniestro->placas,
            'serie' => $siniestro->serie,
            'user_id' => $siniestro->user_id
        ];
    }

    public function siniestroterminado(Request $request, Siniestro $siniestro)
    {
        $this->validate(
            $request,
            [
                'id' => 'required',
            ],
            [
                'id' => 'El id de siniestro es obligatorio',

            ]

        );

        $siniestro->terminado = $request->terminado;
        $siniestro->save();
        if ($request->terminado) {

            $users = [];
            $users = User::where('admin', 1)->get();
            foreach ($users as $usuario) {
                $usuario->notify(new SiniestroTerminado($siniestro->id, $siniestro->nombre, $siniestro->aseguradora_id, Auth::user()->name));
            }
        }


        return [
            'id' => $siniestro->id,
            'terminado' => $siniestro->terminado,
        ];
    }

    public function siniestropagado(Request $request, Siniestro $siniestro)
    {
        $this->validate(
            $request,
            [
                'id' => 'required',
            ],
            [
                'id' => 'El id de siniestro es obligatorio',

            ]

        );

        $user = new User;
        $user = Auth::user();
        if ($user->admin) {

            $siniestro->pagado = $request->pagado;
            $siniestro->save();
        }

        return [
            'id' => $siniestro->id,
            'pagado' => $siniestro->pagado

        ];
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Siniestro $siniestro)
    {
        if ($siniestro->user_id === Auth::user()->id) {
        }
    }
}
