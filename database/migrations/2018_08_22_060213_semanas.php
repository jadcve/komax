<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class Semanas.
 *
 * @author  The scaffold-interface created at 2018-08-22 06:02:13pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class Semanas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('semanas',function (Blueprint $table){

        $table->increments('id');
        
        $table->integer('dia_semana');
        
        $table->String('dia');
        
        $table->integer('calendario_id');
        
        /**
         * Foreignkeys section
         */
        
        
        
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
        Schema::drop('semanas');
    }
}
