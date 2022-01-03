<?php

namespace App\Strategies\DetalleVentaState;

use App\Strategies\DetalleVentaStateInterface;

class Ingreso implements DetalleVentaStateInterface
{
    public function getDetalleVentaState(){
        return ['No Pagado','pedido'];
    }
}