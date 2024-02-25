<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use App\Http\Resources\TareaCollection;
use App\Models\Siniestro;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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



        if ($request->notificacion !== null) {

            $siniestro = Siniestro::find($request->siniestro_id);
            $siniestro->notificacion = json_encode(["num" => $request->notificacion, "Fecha" => Carbon::now(), "time" => $request->time]);
            $siniestro->save();
        }

        $tarea = new Tarea;
        $tarea->nombre = $request->nombre;
        $tarea->siniestro_id = $request->siniestro_id;
        $tarea->admin = $request->admin ?? null;
        $tarea->estado = 0;
        $tarea->save();

        return $tarea;
    }


    public function notificacion(Request $request)
    {   

        //validar la tarea con el request
        $this->validate($request, [
            'nombre' => ['required']
        ]);

        

        $token = '';
        $url = "https://graph.facebook.com/v18.0/238758759321283/messages";
        $mensaje = json_encode(
           [
                "messaging_product" => "whatsapp",
                "to" => "52" . $request->telefono,
                "type" => "template",
                "template" => [
                    "name" => "solicitudreporte",
                    "language"  =>  ["code" => "es_ES"],
                    "components"  => [

                        "type" => "BODY",
                        "parameters" => [

                            [
                                "type" => "text",
                                "text" => $request->numeroNotificacion,
                            ],
                            [
                                "type" => "text",
                                "text" => $request->aseguradoraSiniestro,
                            ],
                            [
                                "type" => "text",
                                "text" => $request->tiempoTranscurrido,
                            ],
                            [
                                "type" => "text",
                                "text" => $request->asignacion_reporte,
                            ],
                        ],

                    ],
                ]
            ]

        );


        $header = array("Authorization: Bearer " . $token, "Content-TYpe: application/json");
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $mensaje);
        curl_setopt($curl, CURLOPT_HEADER, $header);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = json_decode( curl_exec($curl), true);
        //OBTENEMOS EL CODIGO DE LA RESPUESTA
        $status_code = curl_getinfo($curl,CURLINFO_HTTP_CODE);
        // CERRAMOS EL CURL
        curl_close($curl);


        

            $siniestro = Siniestro::find($request->siniestro_id);
            $siniestro->notificacion = json_encode(["num" => $request->notificacion, "Fecha" => Carbon::now(), "time" => $request->time]);
            $siniestro->save();
        

        $tarea = new Tarea;
        $tarea->nombre = $request->nombre;
        $tarea->siniestro_id = $request->siniestro_id;
        $tarea->admin = $request->admin ?? null;
        $tarea->estado = 0;
        $tarea->save();

        return [
            'id' => $tarea->id,
            'nombre' => $tarea->nombre,
            'estado' => $tarea->estado,
            'siniestro_id' => $tarea->siniestro_id,
            'admin' => $tarea->admin
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
            'status' => 200,
            'delete' => 'ok'
        ];
    }
}
