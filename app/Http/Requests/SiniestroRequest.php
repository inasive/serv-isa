<?php

namespace App\Http\Requests;

use App\Models\Siniestro;
use Illuminate\Foundation\Http\FormRequest;

class SiniestroRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'nombre'=>['required', 'string', 'unique:siniestros,nombre'],
            'aseguradora_id' => 'required' ,
        ];
    }
    
    public function messages()
    {
        return[
            'nombre.required' => 'El nombre o número del siniestro es obligatorio',
            'nombre.unique' => 'El siniestro ya esta Registrado',
            'aseguradora_id' => 'Seleccione una aseguradora_id de la lista',
        ];
    }
}
