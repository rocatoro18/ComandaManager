<?php

namespace App\Http\Controllers\Cajero;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mesa as ModelsMesa;
use App\Models\Categoria as ModelsCategoria;
use App\Models\Menu as ModelsMenu;
use App\Models\Venta as ModelsVenta;
use App\Models\DetalleVenta as ModelsDetalleVenta;
use Illuminate\Support\Facades\Auth;

class CajeroController extends Controller
{
    // Primera página de cajero
    public function index(){
        $categorias = ModelsCategoria::all();
        return view('cajero.index')->with('categorias',$categorias);
    }
    
    /**
     * Prueba get mesas
     */

    public function getMesas(){
        $mesas = ModelsMesa::all();
        $html = '';
        foreach($mesas as $mesa){
            $html .= '<div class="col-md-2">';
            $html .= 
            '<button class="btn btn-primary btn-mesa" data-id="'.$mesa->id.'" data-name="'.$mesa->nombre.'">
            <img class="img-fluid" src="'.url('/images/mesa.png').'"/>
            <br>';
            if($mesa->estado == "Disponible"){
                $html .= '<span class="badge bg-success">'.$mesa->nombre.'</span>';
            }else{ // Mesa no disponible
                $html .= '<span class="badge bg-danger">'.$mesa->nombre.'</span>';
            }
            $html .='</button>';
            $html .= '</div>';
        }
        return $html;
    }

    public function getMenuByCategoria($categoria_id){
        $menus = ModelsMenu::where('categoria_id',$categoria_id)->get();
        $html = '';

        foreach($menus as $menu){
            $html .= '
            <div class="col-md-3 text-center">
                <a class="btn btn-outline-secondary btn-menu" data-id="'.$menu->id.'">
                    <img class="img-fluid" src="'.url('/menu_images/'.$menu->image).'">
                    <br>
                    '.$menu->nombre.'
                    <br>
                    $'.number_format($menu->precio).'
                </a>
            </div>
            ';
        }
        return $html;
    }

    public function ordenComanda(Request $request){
        $menu = ModelsMenu::find($request->menu_id);
        $mesa_id = $request->mesa_id;
        $nombre_mesa = $request->nombre_mesa;
        $venta = ModelsVenta::where('mesa_id',$mesa_id)->where('estado_venta','No Pagado')->first();

        // Si no hay venta para la mesa seleccionado, se crea una nueva venta

        if(!$venta){
            $usuario = Auth::user();
            $venta = new ModelsVenta();
            $venta-> mesa_id = $mesa_id;
            $venta-> mesa_nombre = $nombre_mesa;
            $venta-> usuario_id = $usuario->id;
            $venta-> usuario_nombre = $usuario->name;
            $venta->save();
            $venta_id = $venta->id;
            // Actualizar el estado de la mesa
            $mesa = ModelsMesa::find($mesa_id);
            $mesa->estado = "No Disponible";
            $mesa->save();
        
        }else{ // Si hay una venta en la mesa
            $venta_id = $venta->id;
        }

        // Agregar orden menu a los detalles venta tabla
        $DetalleVenta = new ModelsDetalleVenta();
        $DetalleVenta->venta_id =  $venta_id;
        $DetalleVenta->menu_id = $menu->id;
        $DetalleVenta->nombre_menu =  $menu->nombre;
        $DetalleVenta->menu_precio = $menu->precio;
        $DetalleVenta->cantidad = $request->quantity;
        $DetalleVenta->save();

        // Actualizar el precio total en la tabla ventas
        $venta->precio_total = $venta->precio_total + ($request->quantity*$menu->precio);
        $venta->save();

        $html = $this->getDetallesVenta($venta_id);
        return $html;
    }

    public function getDetallesVentaByMesa($mesa_id){
        $venta = ModelsVenta::where('mesa_id',$mesa_id)->where('estado_venta','No Pagado')->first();
        $html = '';

        if($venta){
            $venta_id = $venta->id;
            $html .= $this->getDetallesVenta($venta_id);
        }else{
            $html .= "No se ha encontrado detalles de venta para la mesa seleccionada";
        }

        return $html;
    }

    private function getDetallesVenta($venta_id){

        $html = '<p> Venta ID: '.$venta_id.'</p>';

        $DetalleVenta = ModelsDetalleVenta::where('venta_id',$venta_id)->get();

        $html .= '
        <div class="table-responsive-md style="overflow-y:scroll; height: 400px; border: 1px solid #343A40">
        <table class="table table-stripped table-dark">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Menu</th>
                <th scope="col">Cantidad</th>
                <th scope="col">Precio</th>
                <th scope="col">Total</th>
                <th scope="col">Estado</th>
            </tr>
        </thead>
        <tbody>';

        $showBtnPayment = true;

        foreach($DetalleVenta as $Detalle){

            $decreaseButton = '<button class="btn btn-danger btn-sm btn-decrease-quantity" disabled>-</button>';
            if($Detalle->cantidad > 1){
                $decreaseButton = '<button data-id="'.$Detalle->id.'" class="btn btn-danger btn-sm btn-decrease-quantity">-</button>';
            }

            $html .=  '
            <tr>
                <td>'.$Detalle->menu_id.'</td>
                <td>'.$Detalle->nombre_menu.'</td>
                <td>'. $decreaseButton. ' '. $Detalle->cantidad.'
                <button data-id="'.$Detalle->id.'" class="btn btn-primary btn-sm btn-increase-quantity">+</button></td>
                <td>'.$Detalle->menu_precio.'</td>
                <td>'.($Detalle->menu_precio * $Detalle->cantidad).'</td>';
                if($Detalle->Estado == "No Confirmado"){
                    $showBtnPayment = false;
                    $html .= '<td><a data-id="'.$Detalle->id.'" class="btn btn-danger btn-delete-saledetail"><i class="far fa-trash-alt"></i></a></td>';
                }else{ // Estado confirmado
                    $html .= '<td><i class="fas fa-check-circle"></i></td>';
                }
                $html .= '</tr>';
              
        }

        $html .='</tbody></table></div>';

        $venta = ModelsVenta::find($venta_id);

        $html .= '<hr>';
        $html .= '<h3>Precio Total: $'.number_format($venta->precio_total).'</h3>';

        if($showBtnPayment){
            $html .= '<button data-id="'.$venta_id.'" data-totalAmount="'.$venta->precio_total.'" class="btn btn-success btn-block btn-payment" data-bs-toggle="modal" data-bs-target="#exampleModal">Pagar Orden</button>';
        }else{
            $html .= '<button data-id="'.$venta_id.'" class="btn btn-warning btn-block btn-confirm-order">Confirmar Orden</button>';
        }

        return $html;
    }

    public function ConfirmarOrdenEstado(Request $request){
        $venta_id = $request->venta_id;

        $DetallesVenta = ModelsDetalleVenta::where('venta_id',$venta_id)->update(['Estado'=>'Confirmado']);

        $html = $this->getDetallesVenta($venta_id);

        return $html;
    }

    public function EliminarDetalleVenta(Request $request){
        $detalleVenta_id = $request->detalleVenta_id;
        $detalleVenta = ModelsDetalleVenta::find($detalleVenta_id);
        $venta_id = $detalleVenta->venta_id;
        $menu_precio = ($detalleVenta->menu_precio * $detalleVenta->cantidad);
        $detalleVenta->delete();
        // Actualizar precio total
        $venta = ModelsVenta::find($venta_id);
        $venta->precio_total = $venta->precio_total - $menu_precio;
        $venta->save();
        //Verificar si hay algun detalle de venta que tenga la venta
        $detalleVenta = ModelsDetalleVenta::where('venta_id',$venta_id)->first();

        if($detalleVenta){
            $html = $this->getDetallesVenta($venta_id);
        }else{
            $html = "No se ha encontrado detalles de venta para la mesa seleccionada";
        }

        return $html;
    }

    public function GuardarPago(Request $request){
        $saleID = $request->saleID;
        $receivedAmount = $request->receivedAmount;
        $paymentType = $request->paymentType;
        // Actulizar la informacion de venta en la tabla de ventas usando el modelo de venta
        $venta = ModelsVenta::find($saleID);
        $venta->recibido_total = $receivedAmount;
        $venta->cambio_total = $receivedAmount - $venta->precio_total;
        $venta->tipo_pago = $paymentType;
        $venta->estado_venta = "Pagado";
        $venta->save();
        // Actualizar la mesa para que este disponible
        $mesa = ModelsMesa::find($venta->mesa_id);
        $mesa->estado = "Disponible";
        $mesa->save();
        return "/cajero/mostrarRecibo/".$saleID;
    }

    public function mostrarRecibo($venta_id){
        $venta = ModelsVenta::find($venta_id);
        $detallesVenta = ModelsDetalleVenta::where('venta_id',$venta_id)->get();
        return view('cajero.mostrarRecibo')->with('venta',$venta)->with('detallesVenta',$detallesVenta);
    }

    public function increaseQuantity(Request $request){
        // Actualizar cantidad
        $detalleVenta_id = $request->detalleVenta_id;
        $detalleVenta = ModelsDetalleVenta::where('id',$detalleVenta_id)->first();
        $detalleVenta->cantidad = $detalleVenta->cantidad + 1;
        $detalleVenta->save();
        
        // Actualizar el monto total
        $venta = ModelsVenta::where('id',$detalleVenta->venta_id)->first();
        $venta->precio_total = $venta->precio_total + $detalleVenta->menu_precio;
        $venta->save();

        $html = $this->getDetallesVenta($detalleVenta->venta_id);

        return $html;
    }

    public function decreaseQuantity(Request $request){
        // Actualizar cantidad
        $detalleVenta_id = $request->detalleVenta_id;
        $detalleVenta = ModelsDetalleVenta::where('id',$detalleVenta_id)->first();
        $detalleVenta->cantidad = $detalleVenta->cantidad - 1;
        $detalleVenta->save();
        
        // Actualizar el monto total
        $venta = ModelsVenta::where('id',$detalleVenta->venta_id)->first();
        $venta->precio_total = $venta->precio_total - $detalleVenta->menu_precio;
        $venta->save();

        $html = $this->getDetallesVenta($detalleVenta->venta_id);

        return $html;
    }

}
