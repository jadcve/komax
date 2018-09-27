<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSugeridosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sugeridos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cod_art')->nullable();
			$table->integer('forecast')->nullable();
            $table->integer('ordercicle')->nullable();
            $table->integer('minimo')->nullable();
            $table->integer('sugerido')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sugeridos');
    }
}
