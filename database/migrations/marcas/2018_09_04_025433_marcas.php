<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class Marcas.
 *
 * @author  The scaffold-interface created at 2018-09-04 02:54:33pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class Marcas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('marcas',function (Blueprint $table){

        $table->increments('id');
        
        $table->String('canal');
        
        $table->String('marca');
        
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
        Schema::drop('marcas');
    }
}
