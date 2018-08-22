<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class Nivel_servicios.
 *
 * @author  The scaffold-interface created at 2018-08-22 06:00:55pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class NivelServicios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('nivel_servicios',function (Blueprint $table){

        $table->increments('id');
        
        $table->String('letra');
        
        $table->integer('nivel_servicio');
        
        $table->String('descripcion');
        
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
        Schema::drop('nivel_servicios');
    }
}
