<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MarcasBodegas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('marca_bodega',function (Blueprint $table){
			$table->increments('id')->unique()->index()->unsigned();
			$table->integer('marca_id')->unsigned()->index();
			$table->foreign('marca_id')->references('id')->on('marcas')->onDelete('cascade');
			$table->integer('bodega_id')->unsigned()->index();
			$table->foreign('bodega_id')->references('id')->on('bodegas')->onDelete('cascade');
			/**
			 * Type your addition here
			 *
			 */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::drop('marca_bodega');
    }
}
