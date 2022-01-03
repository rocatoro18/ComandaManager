<?php

namespace App\Strategies\DetalleVentaState;

use App\Strategies\DetalleVentaStateInterface;

class Pedido implements DetalleVentaStateInterface
{
    public function getDetalleVentaState(){
        return ['No Pagado','pagado'];
    }
}