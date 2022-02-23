@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Titulo</th>
                                    <th scope="col">Descripcion</th>
                                    <th scope="col">Location</th>
                                    <th scope="col">date</th>
                                    <th scope="col">opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($eventos as $evento)
                                    <tr>
                                        <th scope="col">{{ $evento->id }}</th>
                                        <th scope="col">{{ $evento->title }}</th>
                                        <th scope="col">{{ $evento->description }}</th>
                                        <th scope="col">{{ $evento->location }}</th>
                                        <th scope="col">{{ $evento->date }}</th>
                                        <th scope="col">
                                            <a href="{{ route('fotografo.evento.details', $evento->id) }}"
                                                class="btn btn-success">Ver Detalles</a>
                                        </th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
