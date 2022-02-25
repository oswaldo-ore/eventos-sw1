<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlbumController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $eventos = $user->asisteEventos()->get();

        dd($eventos);
        return view('cliente.albunes.index');
    }
}
