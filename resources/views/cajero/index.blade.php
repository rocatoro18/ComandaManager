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
            <br>
            <button type="button" class="btn btn-primary"><a href="/home" style="text-decoration: none; text-color:white" >Regresar al Menú Principal</a></button>
        </div>
        <div class="col-md-7">
        <h5>Categorías</h5>
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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pagar Orden</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h3 class="totalAmount"></h3>
        <h3 class="changeAmount"></h3>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">$</span>
            </div>
            <input type="number" id="received-amount" class="form-control">
        </div>
        <div class="form-group">
            <label for="payment">Tipo de Pago</label>
            <select class="form-control" id="payment-type">
                <option value="Efectivo">Efectivo</option>
                <option value="Tarjeta de Crédito">Tarjeta de Crédito</option>
            </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary btn-save-payment" disabled>Guardar Pago</button>
      </div>
    </div>
  </div>
</div>

<script>
    
    // Función para mostrar ó no los detalles de una venta
    $(document).ready(function(){
        $("#table-detail").hide();
        // Función para desplegar u ocultar los detalles de la venta
        $("#btn-show-tables").click(function(){
            // Preguntamos si estan ocultos los detalles de venta
            if ($("#table-detail").is(":hidden")){
                // Función para cargar los datos de venta
                $.get("/cajero/getMesa",function(data){
                    $("#table-detail").html(data);
                    $("#table-detail").slideDown('fast');
                    $("#btn-show-tables").html('Ocultar Mesas').removeClass('btn-primary').addClass('btn-danger');
                })
            } else { 
                $("#table-detail").slideUp('fast');
                $("#btn-show-tables").html('Ver Todas Las Mesas').removeClass('btn-danger').addClass('btn-primary');
            }
        });

        // Cargar menus por categoria
        $(".nav-link").click(function(){
            $.get("/cajero/getMenuByCategoria/"+$(this).data("id"),
                function(data){
                    $("#list-menu").hide();
                    $("#list-menu").html(data);
                    $("#list-menu").fadeIn('fast');
                });
        });

        var SELECTED_MESA_ID = "";
        var SELECTED_MESA_NOMBRE = "";
        var VENTA_ID = "";

        // Detectar boton mesa al clickarlo para mostrar info de la mesa
        $("#table-detail").on("click",".btn-mesa",function(){
            SELECTED_MESA_ID = $(this).data("id");
            SELECTED_MESA_NOMBRE = $(this).data("name");
            $("#selected-table").html('<br><h3>MESA: '+SELECTED_MESA_NOMBRE+'</h3><hr><div id="order-detail"></div>');
            $.get("/cajero/getDetallesVentaByMesa/"+SELECTED_MESA_ID,function(data){
                $('#order-detail').html(data);
            });
        });

        // Función para desplegar el menu del restaurant
        // y agregarlo a los detalles de orden de dicha mesa
        $("#list-menu").on("click",".btn-menu",function(){
            if(SELECTED_MESA_ID == ""){
                alert("Necesita seleccionar primero la mesa para el cliente");
            } else {
                // Asignamos el id seleccionado a la variable
                var menu_id = $(this).data("id");
                // Petición ajax para mandar los detalles de orden
                // a la base de datos
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
                    // En caso de éxito, traemos los datos y poblamos
                    // la tabla de detalles de orden
                    success: function(data){
                        $('#order-detail').html(data);
                    },
               });
           }
        });

        // Confirmamos orden
        $("#selected-table").on('click',".btn-confirm-order",function(){
            var VentaID = $(this).data("id");
            $.ajax({
                type: "POST",
                data: {
                    "_token" : $('<meta name="csrf-token" content="{{ csrf_token() }}">').attr('content'),
                    "venta_id" : VentaID
                },
                url: "/Cajero/ConfirmarOrdenEstado",
                success: function(data){
                    $("#order-detail").html(data);
                }
            });
        });

        // Eliminar detalle venta
        $("#selected-table").on('click',".btn-delete-saledetail",function(){
            var DetalleVentaID = $(this).data("id");
            $.ajax({
                type: "POST",
                data: {
                    "_token" : $('<meta name="csrf-token" content="{{ csrf_token() }}">').attr('content'),
                    "detalleVenta_id": DetalleVentaID
                },
                url: "/Cajero/EliminarDetalleVenta",
                success: function(data){
                    $("#order-detail").html(data);
                }
            });
        });

        // Cuando el usuario da click en el boton de pago
        $("#selected-table").on('click',".btn-payment",function(){
            var totalAmount = $(this).attr('data-totalAmount');
            $(".totalAmount").html("Precio Total: "+totalAmount);
            $("#received-amount").val('');
            $(".changeAmount").html('');
            VENTA_ID = $(this).data('id');
        });

        // Calcular Cambio
        $("#received-amount").keyup(function(){
            var totalAmount = $(".btn-payment").attr('data-totalAmount');
            var receivedAmount = $(this).val();
            var changeAmount = receivedAmount - totalAmount;
            $(".changeAmount").html("Cambio Total: $" + changeAmount);

            //Verificar si el cajero ingreso el monto correcto, 
            //despues habilitar o desabilitar el boton de guardar pago

            if (changeAmount >= 0) {
                $('.btn-save-payment').prop('disabled',false);
            } else
            $('.btn-save-payment').prop('disabled',true);

        });

        // Guardar Pago
        $(".btn-save-payment").click(function(){
            var receivedAmount = $("#received-amount").val();
            var paymentType = $("#payment-type").val();
            var saleId = VENTA_ID;
            $.ajax({
                type: "POST",
                data: {
                    "_token" : $('<meta name="csrf-token" content="{{ csrf_token() }}">').attr('content'),
                    "saleID" : saleId,
                    "receivedAmount": receivedAmount,
                    "paymentType": paymentType
                },
                url: "/Cajero/GuardarPago",
                success: function(data){
                    window.location.href=data;
                }
            });
        });

        // incrementar cantidad
        $("#selected-table").on('click',".btn-increase-quantity",function(){
            var DetalleVentaID = $(this).data("id");
            $.ajax({
                type: "POST",
                data: {
                    "_token" : $('<meta name="csrf-token" content="{{ csrf_token() }}">').attr('content'),
                    "detalleVenta_id": DetalleVentaID
                },
                url: "/Cajero/increase-quantity",
                success: function(data){
                    $("#order-detail").html(data);
                }
            });
        });

        // decrementar cantidad
        $("#selected-table").on('click',".btn-decrease-quantity",function(){
            var DetalleVentaID = $(this).data("id");
            $.ajax({
                type: "POST",
                data: {
                    "_token" : $('<meta name="csrf-token" content="{{ csrf_token() }}">').attr('content'),
                    "detalleVenta_id": DetalleVentaID
                },
                url: "/Cajero/decrease-quantity",
                success: function(data){
                    $("#order-detail").html(data);
                }
            });
        });


    });
</script>
@endsection