<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicios', function (Blueprint $table) {
            $table->string('tipo_servicio', 45)->primary();
            $table->string('razon_social', 100);
            $table->string('rut', 12);
            $table->string('giro', 100);
            $table->string('domicilio', 100);
            $table->string('comuna', 35);
            $table->string('fono', 15)->nullable();
            $table->string('url_logo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servicios');
    }
}
