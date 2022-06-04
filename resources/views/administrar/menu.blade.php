@extends('layouts.app')

@section('content')

<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

    <form action="/administrar/menu-eliminar" method="POST">
    @csrf
    
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Eliminar Menú</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <input type="hidden" name="menu_delete_id" id="menu_id">
        <h5>¿Está seguro de que desea eliminar este menú?</h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
        <button type="submit" class="btn btn-danger">Sí Eliminar</button>
      </div>

    </form>

    </div>
  </div>
</div>

    <div class="container">
        <div class="row justify-content-center">
            @include('administrar.inc.sidebar')
            <div class="col-md-8">
                <i class="fas fa-pizza-slice"></i>Menú
                <a href="/administrar/menu/create" class="btn btn-success btn-sm float-end"><i class="fas fa-plus"></i> Crear Menú</a>           
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
                        <th scope="col">Nombre</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Imagen</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Categoría</th>
                        <th scope="col">Editar</th>
                        <th scope="col">Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                   @foreach($menus as $menu)

                    <tr>
                        <td>{{$menu->id}}</td>
                        <td>{{$menu->nombre}}</td>
                        <td>{{$menu->precio}}</td>
                        <td>
                            <img src="{{asset('menu_images')}}/{{$menu->image}}" alt="$menu->name" width="120px" height="120px" class="img-thumbnail">
                        </td>
                        <td>{{$menu->descripcion}}</td>
                        <td>{{$menu->categoria->nombre}}</td>
                        <td><a href="/administrar/menu/{{$menu->id}}/edit" class="btn btn-warning">Editar</a></td>
                        

                        <td>
                            <!--
                            <form action="/administrar/menu/{{$menu->id}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="submit" value="Eliminar" class="btn btn-danger">
                            </form>
                            -->
                            <button type="button" class="btn btn-danger deleteMenuBtn" value="{{$menu->id}}">Eliminar</button>
                        </td>

                    </tr>

                   @endforeach
                </tbody>
                </table>

            </div>
        </div>
    </div>


@endsection

@section('scripts')

    <script>
        $(document).ready(function(){

            //$('.deleteMenuBtn').click(function(e){
                $(document).on('click','.deleteMenuBtn',function(e){
                    
                e.preventDefault();

                var menu_id = $(this).val();
                $('#menu_id').val(menu_id);
                $('#deleteModal').modal('show');

            });

        });
    </script>

@endsection