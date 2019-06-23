<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->integer('folio');
            $table->integer('contribuyentes__rut');
            $table->string('servicios__tipo_servicio', 45);
            $table->tinyInteger('dia_emision');
            $table->tinyInteger('mes_emision');
            $table->smallInteger('anio_emision');
            $table->tinyInteger('dia_venc');
            $table->tinyInteger('mes_venc');
            $table->smallInteger('anio_venc');
            $table->integer('neto');
            $table->integer('iva');
            $table->integer('total');

            $table->primary(['contribuyentes__rut', 'servicios__tipo_servicio', 'mes_emision', 'anio_emision'], 'facturas_pk');
            $table->foreign('contribuyentes__rut')
                    ->references('rut')->on('contribuyentes')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
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
        Schema::dropIfExists('facturas');
    }
}
