<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class TareaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'estado' => $this->estado,
            'siniestro_id' => $this->siniestro_id,
            'admin'=> $this->admin,
            'creado'=> $this->created_at//Carbon::parse($this->created_at)->format('d-m-Y')
        ];
    }
}
