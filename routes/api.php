<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AseguradoraController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FotoController;
use App\Http\Controllers\FotosController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\NotificacionCuentaController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\SiniestroAdController;
use App\Http\Controllers\SiniestroController;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\TareasController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['auth:sanctum'])->group(function() {

    Route::get('/user', function (Request $request) {
        
        return [
            'user'=>$request->user(),
            'notificacion'=>$request->user()->unreadNotifications->count()
        ];
    });

    
    Route::put('/esadministrador/{user}', [AuthController::class, 'esadministrador']);

    Route::post('/registrousuario', [AuthController::class, 'registeruser']);

    
    Route::apiResource('/edit-perfil', PerfilController::class);
    Route::post('/edit-pass', [AuthController::class, 'editpass']);
    
    Route::apiResource('/siniestros', SiniestroController::class);
    Route::put('/terminarsiniestro/{siniestro}', [SiniestroController::class, 'siniestroterminado']);
    Route::put('/pagarsiniestro/{siniestro}', [SiniestroController::class, 'siniestropagado']);
    
    Route::apiResource('/pagos', PagoController::class);
    
    Route::apiResource('/aseguradoras', AseguradoraController::class);
    
    Route::get('/adsiniestrosall', [SiniestroAdController::class, 'siniestrosAll']);
    Route::apiResource('/adsiniestros', SiniestroAdController::class);
    Route::get('/unsiniestro/{nombre}', [SiniestroAdController::class, 'unSiniestro']);
    Route::put('/reporte-doc/{siniestro}', [SiniestroAdController::class, 'reporte']);
    
    
    Route::apiResource('/tarea', TareaController::class);
    Route::get('/tareas/{siniestro}', [TareasController::class,'index']);
    
    
    Route::apiResource('/foto', FotoController::class);
    Route::get('/fotos/{siniestro}', [FotosController::class, 'index']);                        
    
    
    Route::apiResource('/usuarios', AuthController::class);

    //notificaciones
    Route::get('/notificaciones', NotificacionController::class);
    Route::post('/notificacion', NotificacionCuentaController::class);

});




