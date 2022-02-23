@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Detalle del evento') }}</div>

                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">id: {{ $evento->id }}</li>
                            <li class="list-group-item">titulo: {{ $evento->title }}</li>
                            <li class="list-group-item">ubicacion: {{ $evento->location }}</li>
                            <li class="list-group-item">descripcion: {{ $evento->description }}</li>
                            <li class="list-group-item">Fecha: {{ $evento->date }}</li>
                            <li class="list-group-item">lat: {{ $evento->lat ? $evento->lat : 'no existe lat' }}</li>
                            <li class="list-group-item">lng: {{ $evento->lon ? $evento->lat : 'no existe lng' }}</li>
                        </ul>
                        <br>
                        <a href="{{ route('fotografo.evento.subscribe', $evento->id) }}"
                            class="btn btn-primary">Suscribirse</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
