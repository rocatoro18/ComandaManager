<?php

namespace App\Values;

use App\Strategies\DetalleVentaState\Ingreso;
use App\Strategies\DetalleVentaState\Pedido;
use App\Strategies\DetalleVentaState\Pagado;

final class DetalleVentaStateValues
{
    // CONTEXTO
    const STRATEGY = [
        'ingreso' => Ingreso::class,
        'pedido' => Pedido::class,
        'pagado' => Pagado::class
    ];
}