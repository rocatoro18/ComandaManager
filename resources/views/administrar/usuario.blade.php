@extends('layouts.app')

@section('content')

<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

    <form action="/administrar/user-eliminar" method="POST">
    @csrf
    
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Eliminar Usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <input type="hidden" name="user_delete_id" id="user_id">
        <h5>¿Está seguro de que desea eliminar este usuario?</h5>
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
                <i class="fas fa-user-cog"></i> Usuario
                <a href="/administrar/user/create" class="btn btn-success btn-sm float-end"><i class="fas fa-plus"></i> Crear Usuario</a>           
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
                        <th scope="col">Rol</th>
                        <th scope="col">Email</th>
                        <th scope="col">Editar</th>
                        <th scope="col">Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                   @foreach($users as $user)

                    <tr>
                        <td>{{$user->id}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->role}}</td>
                        <td>{{$user->email}}</td>
                        <td><a href="/administrar/user/{{$user->id}}/edit" class="btn btn-warning">Editar</a></td>
                        
                        <td>
                            <!--
                            <form action="/administrar/user/{{$user->id}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="submit" value="Eliminar" class="btn btn-danger">
                            </form>
                            -->
                            <button type="button" class="btn btn-danger deleteUserBtn" value="{{$user->id}}">Eliminar</button>
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
                $(document).on('click','.deleteUserBtn',function(e){
                    
                e.preventDefault();

                var user_id = $(this).val();
                $('#user_id').val(user_id);
                $('#deleteModal').modal('show');

            });

        });
    </script>

@endsection