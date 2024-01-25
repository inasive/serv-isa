<?php

namespace App\Http\Controllers;


use App\Http\Requests\CambiarPassword;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistroRequest;
use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return['conectando ...'];
        return new UserCollection(User::all());
    }



    public function registeruser(RegistroRequest $request)
    {
        //validar el registro
        $data = $request->validated();

        //Crear el Usuario
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);

        event(new Registered($user));

        
        //retornar respuesta
        return [
            'exito' => 'el usuario Fue creado con exito'
        ];
    }


    public function esadministrador(Request $request, User $user)
    {

        $this->validate(
            $request,
            [
                'name' => ['required', 'string'],

            ],
            [
                'name.required' => 'El nombre del usuario es obligatorio',
            ]

        );
        $userAuth = Auth::user();
        if ($userAuth->admin) {

            $user->admin = (int)$request->admin;
            $user->save();
            return $request;
        }
    }

    public function editpass(CambiarPassword $request): Response
    {
        //validar el registro
         $request->validated();

        //Revisar el password
        $email = $request->get('email');
        $password = $request->get('passAnterior');

        if (!Auth::guard('web')->validate(['email' => $email, 'password' => $password])) {

            return "0";
        }


        $usuario = User::find(Auth::user()->id);
        $usuario->password = bcrypt($request->password);

        $usuario->save();
        // Autenticar el usuario


        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
