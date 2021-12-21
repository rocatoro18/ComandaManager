@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="list-group">
                    <a href="/administrar/categoria" class="list-group-item list-group-item-action"><i class="fas fa-align-justify"></i> Categoría</a>
                    <a class="list-group-item list-group-item-action"><i class="fas fa-pizza-slice"></i> Menú</a>
                    <a class="list-group-item list-group-item-action"><i class="fas fa-chair"></i> Mesa</a>
                    <a class="list-group-item list-group-item-action"><i class="fas fa-user-cog"></i> Usuario</a>    
                </div>
            </div>
            <div class="col-md-8">
                <i class="fas fa-align-justify"></i>Crear una Categoría          
                <hr>
                <form action="/administrar/categoria" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="categoriaNombre">Nombre Categoría</label>
                        <input type="text" name="nombre" class="form-control" placeholder="Nombre Categoría">
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>

@endsection
