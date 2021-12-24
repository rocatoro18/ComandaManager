@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/home">Funciones Principales</a></li>
            <li class="breadcrumb-item"><a href="/reporte">Reporte</a></li>
            <li class="breadcrumb-item active" aria-current="page">Resultado</li>
          </ol>
        </nav>
      </div>
    </div>
    <div class="row">
        <div class="col-md-12">
          @if($ventas->count() > 0)
            <div class="alert alert-success" role="alert">
              <p>La cantidad total de venta del {{$dateStart}} al {{$dateEnd}} es de ${{number_format($totalSale, 2)}}</p>
              <p>Resultado Total: {{$ventas->total()}}</p>
            </div>
            <table class="table">
              <thead>
                <tr class="bg-primary text-light">
                  <th scope="col">#</th>
                  <th scope="col">Recibo ID</th>
                  <th scope="col">Fecha</th>
                  <th scope="col">Mesa</th>
                  <th scope="col">Personal</th>
                  <th scope="col">Monto Total</th>
                </tr>
              </thead>
              <tbody>
                @php 
                  $countSale = ($ventas->currentPage() - 1) * $ventas->perPage() + 1;
                @endphp 
                @foreach($ventas as $venta)
                  <tr class="bg-primary text-light">
                    <td>{{$countSale++}}</td>
                    <td>{{$venta->id}}</td>
                    <td>{{date("m/d/Y H:i:s", strtotime($venta->updated_at))}}</td>
                    <td>{{$venta->mesa_nombre}}</td>
                    <td>{{$venta->usuario_nombre}}</td>
                    <td>{{$venta->precio_total}}</td>
                  </tr>
                  <tr >
                    <th></th>
                    <th>Menu ID</th>
                    <th>Menú</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Precio Total</th>
                  </tr>
                  @foreach($venta->detallesVenta as $saleDetail)
                    <tr>
                      <td></td>
                      <td>{{$saleDetail->menu_id}}</td>
                      <td>{{$saleDetail->nombre_menu}}</td>
                      <td>{{$saleDetail->cantidad}}</td>
                      <td>{{$saleDetail->menu_precio}}</td>
                      <td>{{$saleDetail->menu_precio * $saleDetail->cantidad}}</td>
                    </tr>
                  @endforeach
                @endforeach
              </tbody>
            </table>     

            <form action="/reporte/mostrar/exportar" method="get">
              <input type="hidden" name="dateStart" value="{{$dateStart}}" >
              <input type="hidden" name="dateEnd" value="{{$dateEnd}}" >
              <input type="submit" class="btn btn-warning" value="Exportar a Excel" >
            </form>

          @else
            <div class="alert alert-danger" role="alert">
              No hay Reporte de Venta
            </div>
          @endif
        </div>
    </div>
  </div>

@endsection