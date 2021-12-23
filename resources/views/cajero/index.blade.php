@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row" id="table-detail"></div>
    <br>
    <div class="row justify-content-center">
        <div class="col-md-5">
            <button class="btn btn-primary btn-block" id="btn-show-tables">Ver Todas Las Mesas</button>
        </div>
        <div class="col-md-7"></div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $("#btn-show-tables").click(function(){
            $.get("/cajero/getMesa",function(data){
                $("#table-detail").html(data);
            });
        });
    });
</script>
@endsection