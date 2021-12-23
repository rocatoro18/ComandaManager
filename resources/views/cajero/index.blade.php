@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row" id="table-detail"></div>
    <br>
    <div class="row justify-content-center">
        <div class="col-md-5">
            <button class="btn btn-primary btn-block" id="btn-show-tables">Ver Todas Las Mesas</button>
            <div id="selected-table">
            <div id="order-detail"></div>
            </div>
        </div>
        <div class="col-md-7">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    @foreach($categorias as $categoria)
                        <a class="nav-item nav-link" data-id="{{$categoria->id}}" data-toggle="tab">
                            {{$categoria->nombre}}
                        </a>
                    @endforeach
                </div>
            </nav>
            <div id="list-menu" class="row mt-2">

            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){

        $("#table-detail").hide();


        $("#btn-show-tables").click(function(){
            if($("#table-detail").is(":hidden")){
                $.get("/cajero/getMesa",function(data){
                $("#table-detail").html(data);
                $("#table-detail").slideDown('fast');
                $("#btn-show-tables").html('Ocultar Mesas').removeClass('btn-primary').addClass('btn-danger');
            })
            }else{
                $("#table-detail").slideUp('fast');
                $("#btn-show-tables").html('Ver Todas Las Mesas').removeClass('btn-danger').addClass('btn-primary');
            }
            
        });

        // Cargar menus por categoria

        $(".nav-link").click(function(){
            $.get("/cajero/getMenuByCategoria/"+$(this).data("id"),function(data){
                $("#list-menu").hide();
                $("#list-menu").html(data);
                $("#list-menu").fadeIn('fast');
            });
        });
        var SELECTED_MESA_ID = "";
        var SELECTED_MESA_NOMBRE = "";
        // Detectar boton mesa al clickarlo para mostrar info de la mesa

        $("#table-detail").on("click",".btn-mesa",function(){
            SELECTED_MESA_ID = $(this).data("id");
            SELECTED_MESA_NOMBRE = $(this).data("name");
            $("#selected-table").html('<br><h3>MESA: '+SELECTED_MESA_NOMBRE+'</h3><hr><div id="order-detail"></div>');
        });

        $("#list-menu").on("click",".btn-menu",function(){
           if(SELECTED_MESA_ID == ""){
               alert("Necesita seleccionar primero la mesa para el cliente");
           }else{
               var menu_id = $(this).data("id");   
               $.ajax({
                type: "POST",
                data: {
                    "_token" : $('<meta name="csrf-token" content="{{ csrf_token() }}">').attr('content'),
                    "menu_id" : menu_id,
                    "mesa_id": SELECTED_MESA_ID,
                    "nombre_mesa": SELECTED_MESA_NOMBRE,
                    "quantity": 1
                },
                url: "/cajero/ordenComanda",
                success: function(data){
                    $('#order-detail').html(data);
                },
               });
           }

        });

    });
</script>
@endsection