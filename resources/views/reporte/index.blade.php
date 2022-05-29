@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/home">Funciones Principales</a></li>
            <li class="breadcrumb-item active" aria-current="page">Reporte</li>
          </ol>
        </nav>
      </div>
    </div>
    <div class="row">
      <form action="/reporte/mostrar" method="GET">
        <div class="col-md-12">
        <label>Selecciona Las Fechas Para El Reporte</label>
          <div class="form-group">
            <div class="input-group date" id="date-start" data-target-input="nearest">
                  <input type="text" name="dateStart" class="form-control datetimepicker-input" data-target="#date-start"/>
                  <div class="input-group-append" data-target="#date-start" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
              </div>
          </div>

          <div class="form-group">
           <div class="input-group date" id="date-end" data-target-input="nearest">
                <input type="text" name="dateEnd" class="form-control datetimepicker-input" data-target="#date-end"/>
                <div class="input-group-append" data-target="#date-end" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
          </div>
          <input class="btn btn-primary" type="submit" value="Mostrar Reporte">
          <button type="button" class="btn btn-primary"><a href="/home" style="text-decoration: none; text-color:white" >Regresar al Menú Principal</a></button>
        </div>
      </form>
    </div>
  </div>

  <script type="text/javascript">
      $(function () {
          $('#date-start').datetimepicker({
            format : 'L'
          });
          $('#date-end').datetimepicker({
              format : 'L',
              useCurrent: false
          });
          $("#date-start").on("change.datetimepicker", function (e) {
              $('#date-end').datetimepicker('minDate', e.date);
          });
          $("#date-end").on("change.datetimepicker", function (e) {
              $('#date-start').datetimepicker('maxDate', e.date);
          });
      });
  </script>


@endsection