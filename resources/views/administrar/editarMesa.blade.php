@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            @include('administrar.inc.sidebar')
            <div class="col-md-8">
                <i class="fas fa-chair"></i>Editar una Mesa          
                <hr>
                <form action="/administrar/mesa/{{$mesa->id}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="mesaNombre">Nombre Mesa</label>
                        <input type="text" name="nombre" value="{{$mesa->nombre}}" class="form-control" placeholder="Nombre Mesa">
                    </div>
                    <br>
                    <button type="submit" class="btn btn-warning">Editar</button>
                </form>
            </div>
        </div>
    </div>

@endsection
