<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class PerfilController extends Controller
{
    public function store(Request $request)
        
    {
        $this->validate(
            $request,
            [
                'name' => ['required', 'string', 'unique:users,name,' . Auth::user()->id, 'min:3', 'max:30'],
                'email' =>['required', 'email', 'unique:users,email,' . Auth::user()->id]
            ],
            [
                'name.required' => 'El nombre del usuario es obligatorio',
                'name.unique' => 'El nombre ya existe',
                'email.required' => 'El Email del usuario es obligatorio',
                'email.unique' => 'El Email ya existe',
            ]
        );


        if (Auth::user()->id == $request->id) {
            
            if ($request->hasFile('imagen')) {

                $public_id = Auth::user()->img_id;
                if($public_id){
                    Cloudinary::destroy($public_id);
                }

                //crear la variable para guardar la imagen
                $imagen = $request->file('imagen');
                //crear un nombre para la imagen
                $nombreImagen = Str::uuid() . "." . $imagen->extension();
                //crear el objeto para manipular la imagen con intervetion image
                $imagenServidor = Image::make($imagen);
                //recortar la imagen con el metodo fit de intervetion image
                $imagenServidor->fit(1000, 1000);

                // Guarda la imagen manipulada en una variable temporal
                $imgClaudinary = tempnam(sys_get_temp_dir(), 'img');

                // Guarda la imagen manipulada en la variable temporal
                $imagenServidor->save($imgClaudinary);

                // Sube la imagen a Cloudinary
                $folder = 'perfiles';
                $foto = cloudinary()->upload($imgClaudinary, ['folder' => $folder]);

                // Borra la imagen temporal
                unlink($imgClaudinary);
                // return $nombreImagen;

                $usuario = User::find(Auth::user()->id);
                $usuario->name = $request->name;
                $usuario->email = $request->email;
                $usuario->telefono = $request->telefono ?? Auth::user()->telefono ?? '';
                $usuario->imagen = $foto->getSecurePath();
                $usuario->img_id = $foto->getPublicId();
                $usuario->save();
                return $usuario;
            
            } 

        
                $usuario = User::find(Auth::user()->id);

                if(Auth::user()->email !== $request->email){
                    $usuario->email_verified_at = null;
                }

                $usuario->name = $request->name;
                $usuario->email = $request->email;
                $usuario->telefono = $request->telefono ?? Auth::user()->telefono ?? '';
                $usuario->imagen = Auth::user()->imagen ?? null;
                
                
                $usuario->save();
                return $usuario;  
                




            
        }
    }
}
