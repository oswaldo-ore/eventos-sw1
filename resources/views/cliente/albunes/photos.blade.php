@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Evento: {{ $title }}</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>


    <!-- Default box -->
    <div class="col-md-10 m-auto">
        <div class="card card-solid">
            <div class="card-body pb-0">
                <div class="row d-flex align-items-stretch">
                    @foreach ($fotos as $foto)
                        <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                            <div class="card bg-light">
                                <div class="card-header text-muted border-bottom-0">

                                </div>
                                <div class="card-body pt-0">
                                    <div class="row">

                                        <div class="col-12">
                                            <img src="{{ $foto->url }}" alt="user-avatar" class="img img-fluid">
                                            <br>
                                            <h2 class="lead"><b></b></h2>

                                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                                <li class="small"><span class="fa-li"><i
                                                            class="fas fa-lg fa-building"></i></span> Address:
                                                </li>
                                                <li class="small"><span class="fa-li"><i
                                                            class="fas fa-lg fa-phone"></i></span> Phone #: + 800 - 12 12 23
                                                    52
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="text-right">

                                        <a href="#" class="btn btn-sm btn-primary">
                                            <i class="fas fa-user"></i> Ver todo
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <nav aria-label="Contacts Page Navigation">
                    <ul class="pagination justify-content-center m-0">
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    </ul>
                </nav>
            </div>
            <!-- /.card-footer -->
        </div>
    </div>
    <!-- /.card -->
@endsection
