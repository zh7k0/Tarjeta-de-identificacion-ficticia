<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_facturas', function (Blueprint $table) {
            $table->string('servicios__tipo_servicio')->primary();
            $table->string('detalles', 450);
            $table->string('cantidades', 100)->nullable();
            $table->string('porcen_por_detalle', 50);

            $table->foreign('servicios__tipo_servicio')
                    ->references('tipo_servicio')->on('servicios')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('config_facturas');
    }
}
