<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class Calendarios.
 *
 * @author  The scaffold-interface created at 2018-08-22 06:06:23pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class Calendarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('calendarios',function (Blueprint $table){

        $table->increments('id');
        
        $table->integer('dia_despacho');
        
        $table->integer('lead_time');
        
        $table->integer('tiempo_entrega');
        
        $table->integer('bodega_id');
        $table->foreign('bodega_id')->references('id')->on('bodegas');
        $table->foreign('user_id')->references('id')->on('users');

        $table->integer('dia_reposicion');
        
        /**
         * Foreignkeys section
         */
        
        
        $table->timestamps();
        
        
        $table->softDeletes();
        
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
        Schema::drop('calendarios');
    }
}
