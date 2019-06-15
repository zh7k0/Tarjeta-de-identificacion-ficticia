<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicioContratadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicios_contratados', function (Blueprint $table) {
            $table->integer('contribuyentes__rut');
            $table->string('servicios__tipo_servicio', 45);
            $table->integer('tarifa')->unsigned();
            /**
             * Los campos a continuación son opcionales,
             * si no están presentes se utilizarán los campos
             * que trae la configuración de factura para el
             * servicio señalado.
             */
            $table->string('detalles', 450)->nullable();
            $table->string('cantidades', 100)->nullable();
            $table->string('porc_por_detalle', 50)->nullable();

            $table->primary(['contribuyentes__rut', 'servicios__tipo_servicio'], 'servicios_contratados_pk');
            $table->foreign('contribuyentes__rut')
                    ->references('rut')->on('contribuyentes')
                    ->onDelete('cascade');
            $table->foreign('servicios__tipo_servicio', 'tipo_servicio_fk')
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
        Schema::dropIfExists('servicio_contratados');
    }
}
