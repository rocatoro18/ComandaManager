<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('mesa_id');
            $table->string('mesa_nombre');
            $table->integer('usuario_id');
            $table->string('usuario_nombre');
            $table->decimal('precio_total')->default(0);
            $table->decimal('recibido_total')->default(0);
            $table->decimal('cambio_total')->default(0);
            $table->string('tipo_pago')->default(""); // Dinero o Tarjeta de Crédito
            $table->string('estado_venta')->default("No Pagado"); // Pagado y No Pagado
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventas');
    }
}
