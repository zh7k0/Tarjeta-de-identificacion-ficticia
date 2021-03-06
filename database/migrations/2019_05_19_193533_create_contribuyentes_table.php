<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContribuyentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contribuyentes', function (Blueprint $table) {
            $table->integer('rut');
            $table->string('razon_social', 100)->unique();
            $table->string('dig_verificador', 1);
            $table->tinyInteger('tipo_contribuyente')->default(2);//1: Persona Natural, 2: Persona Juridica
            $table->string('domicilio', 100);
            $table->string('comuna', 100)->nullable();
            $table->unsignedInteger('giro_id');
            $table->decimal('variabilidad_cobros', 3, 2)->default(0.1);
            // $table->softDeletes();
            $table->primary('rut');
            $table->foreign('giro_id')
                    ->references('id')->on('giros')
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
        Schema::dropIfExists('contribuyentes');
    }
}
