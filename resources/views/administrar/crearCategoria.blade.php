@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            @include('administrar.inc.sidebar')
            <div class="col-md-8">
                <i class="fas fa-align-justify"></i>Crear una Categoría          
                <hr>
                <form action="/administrar/categoria" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="categoriaNombre">Nombre Categoría</label>
                        <input type="text" name="nombre" class="form-control" placeholder="Nombre Categoría" autocomplete="off">
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>

@endsection
