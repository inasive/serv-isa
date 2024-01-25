<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificacionCuentaController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // Auth::user()->unreadNotifications
        //     ->when($request->input('id'), function($query) use($request){
        //         return $query->where($request->input('id'));
        //     })->markAsRead();
        
            Auth::user()->unreadNotifications
            ->when($request->id, function ($query) use ($request) {
                return $query->where('id', $request->id);
            })
            ->markAsRead();

            return response()->noContent();;
    }

}
