@extends('layouts.app')

@section('content')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Sorry!</strong> There were more problems with your HTML input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif



    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Subir Fotos') }}</div>

                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">titulo: {{ $evento->title }}</li>
                            <li class="list-group-item">ubicacion: {{ $evento->location }}</li>
                            <li class="list-group-item">Fecha: {{ $evento->date }}</li>
                        </ul>
                        <br>
                        <form action="{{ route('fotografo.subscription.save-photos', $evento->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class=" input-group mb-3">
                                <input type="file" name="photos[]" class="form-control" id="photos[]" multiple
                                    accept="image/*">
                                <label class="input-group-text" for="photos">upload</label>
                            </div>
                            <br>
                            <button class="brn btn-primary">Guardar</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
