@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Fotografos Postulantes') }}</div>


                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">nombre</th>
                                    <th scope="col">apellido</th>
                                    <th scope="col">email</th>
                                    <th scope="col">opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($fotografos as $fotografo)
                                    <tr>
                                        <th scope="col">{{ $fotografo->id }}</th>
                                        <th scope="col">{{ $fotografo->name }}</th>
                                        <th scope="col">{{ $fotografo->lastname }}</th>
                                        <th scope="col">{{ $fotografo->email }}</th>
                                        <th scope="col">
                                            @if ($fotografo->pivot->accepted)
                                            @else
                                                <a href="{{ route('evento.postulantes.aceptar', [$evento->id, $fotografo->id]) }}"
                                                    class="btn btn-primary">
                                                    aceptar</a>
                                            @endif

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
