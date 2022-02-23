@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Mis suscripciones') }}</div>

                    <div class="card-body">
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
                                @foreach ($subscriptions as $subscription)
                                    <tr>
                                        <th scope="col">{{ $subscription->id }}</th>
                                        <th scope="col">{{ $subscription->title }}</th>
                                        <th scope="col">{{ $subscription->description }}</th>
                                        <th scope="col">{{ $subscription->location }}</th>
                                        <th scope="col">{{ $subscription->date }}</th>
                                        <th scope="col">
                                            <a href="{{ route('fotografo.subscription.upload-photo', $subscription->id) }}"
                                                class="btn btn-success">Subir fotos</a>
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
