<?php

namespace App\Http\Controllers;

use App\Events\EventoEvent;
use App\Models\Cliente;
use App\Models\Evento;
use App\Models\Foto;
use App\Notifications\EventoNotification;
use Aws\S3\BucketEndpointMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlbumController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $eventos = $user->asisteEventos()->with("fotos:id,url,evento_id")->inRandomOrder()->get();
        return view('cliente.albunes.index', compact('eventos'));
    }


    public function photoEvento(Evento $evento)
    {
        $fotos = $evento->fotos;
        $title = $evento->title;
        return view('cliente.albunes.photos', compact('fotos', 'title'));
    }

    public function markAsNotification(Evento $evento, $id)
    {
        Auth::user()->unreadNotifications->when($id, function ($query) use ($id) {
            return $query->where('id', $id);
        })->markAsRead();
        return redirect('/album/' . $evento->id . "");
    }
}
