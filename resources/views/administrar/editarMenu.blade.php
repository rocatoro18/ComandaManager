@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            @include('administrar.inc.sidebar')
            <div class="col-md-8">
            <i class="fas fa-pizza-slice"></i>Editar un Menú          
                <hr>
                <form action="/administrar/menu/{{$menu->id}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="menuNombre">Nombre Menú</label>
                        <input type="text" name="nombre" class="form-control" value="{{old('nombre',$menu->nombre)}}" placeholder="Nombre Menú">
                        @error('nombre')
                            <small style="color: red;">*{{$message}}</small>
                        <br>
                        @enderror
                        <label for="precioMenu">Precio Menú</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            </div>
                            <input type="text" name="precio" value="{{old('precio',$menu->precio)}}" class="form-control" aria-label="Monto (al peso más cercano)">
                        </div>
                        @error('precio')
                            <small style="color: red;">*{{$message}}</small>
                            <br>
                        @enderror
                    <label for="imagenMenu">Imagen Menú</label>
                    <div class="input-group mb-3">
                        <input type="file" name="image" class="form-control" id="inputGroupFile01">
                        <label class="input-group-text" for="inputGroupFile01">Subir</label>
                    </div>                  
                    </div>
                    <div class="form-group">
                        <label for="Descripcion">Descripción Menú</label>
                        <input type="text" name="descripcion" value="{{old('descripcion',$menu->descripcion)}}" class="form-control" placeholder="Descripción Menú">
                    </div>
                    @error('descripcion')
                            <small style="color: red;">*{{$message}}</small>
                            <br>
                        @enderror
                    <div class="form-group">
                        <label for="Categoria">Categoría Menú</label>
                        <select class="form-control" name="categoria_id">
                            @foreach($categorias as $categoria)
                                <option value="{{$categoria->id}}" {{$menu -> categoria_id === $categoria -> id ? 'selected': ''}}>
                                    {{$categoria->nombre}}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <br>
                    <button type="submit" class="btn btn-warning">Editar</button>
                </form>
            </div>
        </div>
    </div>

@endsection