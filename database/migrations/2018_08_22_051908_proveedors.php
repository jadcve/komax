<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class Proveedors.
 *
 * @author  The scaffold-interface created at 2018-08-22 05:19:09pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class Proveedors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('proveedors',function (Blueprint $table){

        $table->increments('id');
        
        $table->String('cod_prov');
        
        $table->String('nombre_prov');
        
        $table->String('leedt_prov');
        
        $table->String('tentrega_prov');
        
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
        Schema::drop('proveedors');
    }
}
