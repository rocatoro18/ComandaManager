<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peccata Minuta - Recibo - VentaID : {{$venta->id}}</title>
    <link type="text/css" rel="stylesheet" href="{{asset('/css/recibo.css')}}" media="all">
    <link type="text/css" rel="stylesheet" href="{{asset('/css/no-print.css')}}" media="print">
</head>
<body>
    <div id="wrapper">
        <div id="receipt-header">
            <h3 id="restaurant-name">Peccata Minuta</h3>
            <p>Dirección: Boulevard Solidaridad</p>
            <p>Hermosillo Sonora</p>
            <p>Tel: 662-XXX-XXXX</p>
            <p>Referencia Recibo: <strong>{{$venta->id}}</strong></p>
        </div>
        <div id="receipt-body">
            <table class="tb-sale-detail">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Menú</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($detallesVenta as $detalleVenta)
                <tr>
                    <td width="30">{{$detalleVenta->menu_id}}</td>
                    <td width="30">{{$detalleVenta->nombre_menu}}</td>
                    <td width="30">{{$detalleVenta->cantidad}}</td>
                    <td width="30">{{$detalleVenta->menu_precio}}</td>
                    <td width="30">{{$detalleVenta->menu_precio * $detalleVenta->cantidad}}</td>
                </tr>
                @endforeach
            </tbody>
            </table>
            <table class="tb-sale-total">
                <tbody>
                    <tr>
                        <td>Total Cantidad</td>
                        <td>{{$detalleVenta->count()}}</td>
                        <td>Total</td>
                        <td>{{number_format($venta->precio_total,2)}}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Tipo de Pago</td>
                        <td colspan="2">{{$venta->tipo_pago}}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Monto Pagado</td>
                        <td colspan="2">${{number_format($venta->recibido_total,2)}}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Cambio</td>
                        <td colspan="2">${{number_format($venta->cambio_total,2)}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="receipt-footer">
            <p>¡Gracias por su preferencia!</p>
        </div>
        <div id="buttons">
            <a href="/cajero">
            <button class="btn btn-back">
                Volver al Cajero
            </button>
            </a>
            <button class="btn btn-print" type="button" onclick="window.print(); return false;">
                Imprimir
            </button>
        </div>
    </div>
</body>
</html>