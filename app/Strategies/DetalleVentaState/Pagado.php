<?php

namespace App\Strategies\DetalleVentaState;

use App\Strategies\DetalleVentaStateInterface;

class Pagado implements DetalleVentaStateInterface
{
    public function getDetalleVentaState(){
        return ['Pagado'];
    }
}