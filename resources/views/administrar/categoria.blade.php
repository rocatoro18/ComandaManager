@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            @include('administrar.inc.sidebar')
            <div class="col-md-8">
                <i class="fas fa-align-justify"></i>Categoría
                <a href="categoria/create" class="btn btn-success btn-sm float-end"><i class="fas fa-plus"></i> Crear Categoría</a>           
                <hr>
                @if(Session()->has('status'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">X</button>
                    {{Session()->get('status')}}
                </div>
                @endif
                <table class="table table-bordered">
                <thead>
                    <tr>
                        <!--<th scope="col">ID</th>-->
                        <th scope="col">Categoría</th>
                        <th scope="col">Editar</th>
                        <!--<th scope="col">Eliminar</th>-->
                    </tr>
                </thead>
                <tbody>
                    @foreach($categorias as $categoria)
                    <tr>
                        <!--<th scope="row">{{$categoria->id}}</th>-->
                        <th>{{$categoria->nombre}}</th>
                        <th>
                            <a href="/administrar/categoria/{{$categoria->id}}/edit" class="btn btn-warning">Editar</a>
                        </th>
                        <!--
                        <th>
                        <form action="/administrar/categoria/{{$categoria->id}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="submit" value="Eliminar" class="btn btn-danger">
                        </form>
                        </th>
                        -->
                    </tr>


                    @endforeach
                </tbody>
                </table>
                <!--
                {{$categorias->links()}}
                -->
            </div>
        </div>
    </div>

@endsection
