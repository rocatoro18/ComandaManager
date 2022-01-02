@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            @include('administrar.inc.sidebar')
            <div class="col-md-8">
            <i class="fas fa-pizza-slice"></i>Crear un Menú          
                <hr>
                <form action="/administrar/menu" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="menuNombre">Nombre Menú</label>
                        <input type="text" name="nombre" class="form-control" placeholder="Nombre Menú" autocomplete="off">
                        <label for="precioMenu">Precio Menú</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            </div>
                            <input type="text" name="precio" class="form-control" aria-label="Monto (al peso más cercano)" autocomplete="off">
                            <div class="input-group-append">
                                <span class="input-group-text">.00</span>
                            </div> 
                        </div>
                    <label for="imagenMenu">Imagen Menú</label>
                    <div class="input-group mb-3">
                        <input type="file" name="image" class="form-control" id="inputGroupFile01">
                        <label class="input-group-text" for="inputGroupFile01">Subir</label>
                    </div>                  
                    </div>
                    <div class="form-group">
                        <label for="Descripcion">Descripción Menú</label>
                        <input type="text" name="descripcion" class="form-control" placeholder="Descripción Menú" autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label for="Categoria">Categoría Menú</label>
                        <select class="form-control" name="categoria_id">
                            @foreach($categorias as $categoria)
                                <option value="{{$categoria->id}}">
                                    {{$categoria->nombre}}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <br>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>

@endsection