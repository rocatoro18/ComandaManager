<?php

namespace App\Http\Controllers\Reporte;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Venta as ModelsVenta;
use App\Exports\ReporteVentaExport;
use Maatwebsite\Excel\Facades\Excel;

class ReporteController extends Controller
{
    public function index(){
        return view('reporte.index');
    }
    
    public function mostrar(Request $request){
        $request->validate([
            'dateStart' => 'required',
            'dateEnd' => 'required'
        ]);
        $dateStart = date("Y-m-d H:i:s", strtotime($request->dateStart.' 00:00:00'));
        $dateEnd = date("Y-m-d H:i:s", strtotime($request->dateEnd.' 23:59:59'));
        $ventas = ModelsVenta::whereBetween('updated_at', [$dateStart, $dateEnd])->where('estado_venta','Pagado');
        return view('reporte.mostrarReporte')->with('dateStart', date("m/d/Y H:i:s", strtotime($request->dateStart.' 00:00:00')))->with('dateEnd', date("m/d/Y H:i:s", strtotime($request->dateEnd.' 23:59:59')))->with('totalSale', $ventas->sum('precio_total'))->with('ventas', $ventas->paginate(5));
    }

    public function exportar(Request $request){
        return Excel::download(new ReporteVentaExport($request->dateStart, $request->dateEnd), 'ReporteVenta.xlsx');
    }

}
