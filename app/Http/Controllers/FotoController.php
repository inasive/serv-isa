<?php

namespace App\Http\Controllers;


use App\Models\Foto;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class FotoController extends Controller
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
        $imagen = $request->file('file');
        $nombreImagen = Str::uuid();
        $imagenServidor = Image::make($imagen);
        $heightImagen = $imagenServidor->height();
        $widthImagen = $imagenServidor->width();


        $valorEscala = 720;

        if ($widthImagen  <= $heightImagen) {

            if ($widthImagen <= $valorEscala) {
                $width = "" . $widthImagen;
                $height = "" . $heightImagen;
            } else {

                $altura = $heightImagen * ($valorEscala / $widthImagen);

                $width =  "" . $valorEscala;
                $height = "" . $altura;
            }
        }

        if ($widthImagen > $heightImagen) {

            if ($heightImagen < $valorEscala) {
                $width = "" . $widthImagen;
                $height = "" . $heightImagen;
            } else {

                $ancho = $widthImagen * ($valorEscala / $heightImagen);
                $width =  "" . $ancho;
                $height = "" . $valorEscala;
            }
        }
        $quality = 'auto';
        $fetch = 'auto';
        $crop = 'scale';
        $folder = 'siniestros';

        $optimal = cloudinary()->upload($imagen->getRealPath(), [
            'folder'         => $folder,
            'transformation' => [
                'width'   => $width,
                'height'  => $height,
                'quality' => $quality,
                'fetch'   => $fetch,
                'crop'    => $crop
            ]
            ], $nombreImagen,);

        
        $foto = new Foto();
        $foto->nombre = $optimal->getPublicId();
        $foto->url = $optimal->getSecurePath();
        $foto->descripcion = "";
        $foto->siniestro_id = $request->siniestro_id;
        $foto->save();

        return $foto;

    }

    /**
     * Display the specified resource.
     */
    public function show(Foto $foto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Foto $foto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Foto $foto)
    {

        Cloudinary::destroy($foto->nombre);
        $foto->delete();
        return [
            'res'=> true,
            'mensaje'=> 'La foto ha sido eliminada'
        ];
    }
}
