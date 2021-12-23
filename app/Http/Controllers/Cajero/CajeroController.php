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
    //
    public function getMesas(){
        $mesas = ModelsMesa::all();
        $html = '';
        foreach($mesas as $mesa){
            $html .= '<div class="col-md-2">';
            $html .= 
            '<button class="btn btn-primary btn-mesa" data-id="'.$mesa->id.'" data-name="'.$mesa->nombre.'">
            <img class="img-fluid" src="'.url('/images/mesa.png').'"/>
            <br>
            <span class="badge badge-success">'.$mesa->nombre.'</span>
            </button>';
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
            $mesa = ModelsMenu::find($mesa_id);
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
        return $html; // TEST

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

        foreach($DetalleVenta as $Detalle){
            $html .=  '
            <tr>
                <td>'.$Detalle->menu_id.'</td>
                <td>'.$Detalle->nombre_menu.'</td>
                <td>'.$Detalle->cantidad.'</td>
                <td>'.$Detalle->menu_precio.'</td>
                <td>'.($Detalle->menu_precio * $Detalle->cantidad).'</td>
                <td>'.$Detalle->Estado.'</td>
            </tr>
            ';
        }

        $html .='</tbody></table></div>';

        return $html;
    }

}
