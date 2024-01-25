<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Siniestro;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PagoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'siniestro_id'=> ['required', 'unique:pagos,siniestro_id,'. $request->siniestro_id],
                'monto' => ['required', 'numeric'],
                'pago_verificador' => ['required', 'numeric'],
                'fecha_pago'=> ['required'],
                
            ],
            [
                'monto.required' => 'El monto del pago es obligatorio',
                'pago_verificador' => 'El pago al verificador es obligatorio',
                'siniestro_id.unique'=> 'El siniestro ya esta pagado'
            ]

        );

        $siniestro = Siniestro::find($request->siniestro_id);
        $pago = new Pago();
        $pago->fecha_pago = $request->fecha_pago ;
        $pago->monto = $request->monto;
        $pago->iva = $request->iva;
        $pago->total = $request->total;
        $pago->pago_verificador = $request->pago_verificador;
        $pago->siniestro_id = $request->siniestro_id;
        $pago->save();
        
        $siniestro->update(['pagado' => 1]);

        return [

            "fecha_pago" => $pago->fecha_pago,
            "monto" => $pago->monto,
            "iva" => $pago->iva,
            "total" => $pago->total,
            "pago_verificado" => $pago->pago_verificador,
            "pagado"=> $siniestro->pagado
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
