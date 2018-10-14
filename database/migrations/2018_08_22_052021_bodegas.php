<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class Bodegas.
 *
 * @author  The scaffold-interface created at 2018-08-22 05:20:21pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class Bodegas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('bodegas',function (Blueprint $table){

        $table->increments('id');
        $table->String('cod_bodega');
        $table->String('bodega');
        $table->String('agrupacion1');
        $table->String('ciudad');
        $table->String('comuna');
        $table->String('region');
        $table->String('longitud');
        $table->String('direccion');
        $table->String('latitude');
        $table->foreign('user_id')->references('id')->on('users');
        $table->boolean('centro_distribucion');

        /**
         * Foreignkeys section
         */


        $table->timestamps();


        // type your addition here

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::drop('bodegas');
    }
}
