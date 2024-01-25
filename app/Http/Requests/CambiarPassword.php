<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password as PasswordRules;
class CambiarPassword extends FormRequest
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
            'name' => ['required', 'string', 'unique:users,name,' . Auth::user()->id, 'min:3', 'max:30'],
            'passAnterior' => 'required',
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => [
                'required',
                'confirmed',
                PasswordRules::min(8)->letters()->symbols()->numbers()
            ]
        ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'El nombre o número del siniestro es obligatorio',
            'nombre.unique' => 'El siniestro ya esta Registrado',
            'email.required' => 'El email es obligatorio',
            'email.email' => 'El email no es valido',
            'email.exists' => 'Esa cuenta no existe',
            'password' => 'Escriba el mismo password, El password deve contener al menos 8 caracteres, un simbolo y un numero'
        ];
    }
}
