@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            @include('administrar.inc.sidebar')
            <div class="col-md-8">
                <i class="fas fa-chair"></i>Mesa
                <a href="mesa/create" class="btn btn-success btn-sm float-end"><i class="fas fa-plus"></i> Crear Mesa</a>           
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
                        <th scope="col">ID</th>
                        <th scope="col">Mesa</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Editar</th>
                        <th scope="col">Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                   @foreach($mesas as $mesa)
                
                   <tr>
                       <td>{{$mesa->id}}</td>
                       <td>{{$mesa->nombre}}</td>
                       <td>{{$mesa->estado}}</td>
                       <td>
                           <a href="/administrar/mesa/{{$mesa->id}}/edit" class="btn btn-warning">Editar</a>
                       </td>
                       <td></td>
                   </tr>

                   @endforeach
                </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
