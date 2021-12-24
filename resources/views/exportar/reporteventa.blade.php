<table>
              <thead>
                <tr>
                  <th>#</th>
                  <th>Recibo ID</th>
                  <th>Fecha</th>
                  <th>Mesa</th>
                  <th>Personal</th>
                  <th>Monto Total</th>
                </tr>
              </thead>
              <tbody>
                @php 
                  $countSale = 1;
                @endphp 
                @foreach($ventas as $venta)
                  <tr>
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
                <tr>
                    <td colspan="5">Monto Total Del {{$dateStart}} al {{$dateEnd}}</td>
                    <td>{{number_format($totalSale,2)}}</td>
                </tr>
              </tbody>
            </table>