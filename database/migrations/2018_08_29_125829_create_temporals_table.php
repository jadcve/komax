<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemporalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * Genera una tabla auxiliar que ayuda al calculo ABC
     *
     * @return void
     */

    public function up()
    {
        Schema::create('temporals', function (Blueprint $table) {

            $table->increments('id');
            $table->String('cod_art');
            $table->String('canal');
            $table->integer('netamount');
            $table->integer('qty');
            $table->float('calc');
            $table->float('acum');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('temporals');
    }
}
