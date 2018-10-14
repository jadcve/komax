<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaestroArticulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maestro_articulos', function (Blueprint $table) {

            $table->string('codigo_color', 20);
            $table->string('descripcion_color', 100);
            $table->string('codigo_talla', 20);
            $table->string('descripcion_talla', 20);            
            $table->bigInteger('precio_iva_incl');
            $table->bigInteger('costo');
            $table->string('marca', 20);       
            $table->string('area', 20);         
            $table->string('linea', 20);
            $table->string('negocio', 20);            
            $table->string('division', 20);            
            $table->string('temporada', 20);            
            $table->string('desc_producto', 100);            
            $table->string('familia', 100);            
            $table->string('sub_familia', 100);            
            $table->string('sku', 100);            
            $table->string('itemid', 100);            
            $table->string('categoria', 100);            
			$table->bigInteger('id_prod');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('maestro_articulos');
    }
}
