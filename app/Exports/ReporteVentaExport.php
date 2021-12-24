<?php

namespace App\Exports;
use App\Models\Venta as ModelsVenta;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReporteVentaExport implements FromView
{
    private $dateStart;
    private $dateEnd;
    private $sales;
    private $totalSale;
    public function __construct($dateStart, $dateEnd){
        $dateStart = date("Y-m-d H:i:s", strtotime($dateStart));
        $dateEnd = date("Y-m-d H:i:s", strtotime($dateEnd));
        $sales = ModelsVenta::whereBetween('updated_at', [$dateStart, $dateEnd])->where('estado_venta','Pagado')->get();
        $totalSale = $sales->sum('precio_total');
        $this->dateStart = $dateStart;
        $this->dateEnd = $dateEnd;
        $this->sales = $sales;
        $this->totalSale = $totalSale;
    }
    public function view(): View
    {
        return view('exportar.reporteventa', [
            'ventas' => $this->sales,
            'totalSale' => $this->totalSale,
            'dateStart' => $this->dateStart,
            'dateEnd' => $this->dateEnd
        ]);
    }
}
