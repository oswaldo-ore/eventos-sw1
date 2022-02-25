<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventoRequest;
use App\Models\Evento;
use App\Models\Fotografo;
use App\Models\Suscripcion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $eventos = $user->eventos;
        return view('cliente.evento.index')->with("eventos", $eventos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cliente.evento.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventoRequest $request)
    {
        $user = Auth::user();
        $evento = new Evento();
        $evento->title = $request->title;
        $evento->description = $request->description;
        $evento->location = $request->location;
        $evento->date = $request->date;
        $evento->cliente_id = $user->id;
        $evento->save();
        return redirect('/home');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function show(Evento $evento)
    {
        $fotografos = $evento->fotografos()->withPivot("accepted")->get();
        return view("cliente.postulantes.index", compact('fotografos', "evento"));
    }

    public function aceptarFotografo(Evento $evento, Fotografo $fotografo)
    {
        $suscription = $evento->fotografos()->updateExistingPivot($fotografo->id, ["accepted" => true]);
        if ($suscription) {
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function edit(Evento $evento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Evento $evento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Evento $evento)
    {
        //
    }
}
