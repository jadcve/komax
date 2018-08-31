<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class Tiendas.
 *
 * @author  The scaffold-interface created at 2018-08-22 05:20:21pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class Tiendas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('tiendas',function (Blueprint $table){

        $table->increments('id');
        $table->String('cod_tienda');
        $table->String('bodega');
        $table->String('canal');
        $table->String('ciudad');
        $table->String('comuna');
        $table->String('region');
        $table->String('latitude');
        $table->String('longitud');
        $table->String('direccion');

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
        Schema::drop('tiendas');
    }
}
