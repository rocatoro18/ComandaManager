@extends('layouts.app')

@section('content')

<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

    <form action="/administrar/mesa-eliminar" method="POST">
    @csrf
    
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Eliminar Mesa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <input type="hidden" name="mesa_delete_id" id="mesa_id">
        <h5>¿Está seguro de que desea eliminar esta mesa?</h5>
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
                       
                       <td>
                           <!--
                           <form action="/administrar/mesa/{{$mesa->id}}" method="POST">
                            @csrf 
                            @method('DELETE')
                            <input type="submit" value="Eliminar" class="btn btn-danger">
                           </form>
                            -->
                            <button type="button" class="btn btn-danger deleteMesaBtn" value="{{$mesa->id}}">Eliminar</button>
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
                $(document).on('click','.deleteMesaBtn',function(e){
                    
                e.preventDefault();

                var mesa_id = $(this).val();
                $('#mesa_id').val(mesa_id);
                $('#deleteModal').modal('show');

            });

        });
    </script>

@endsection