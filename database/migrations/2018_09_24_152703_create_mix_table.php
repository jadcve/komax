<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMixTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mix', function(Blueprint $table)
		{
			$table->float('minimo', 10, 0)->nullable();
			$table->string('estilo', 25)->nullable();
			$table->string('talla', 10)->nullable();
			$table->string('tienda', 50)->nullable();
			$table->string('sku', 30)->nullable();
			$table->string('cod_art', 50)->nullable();
			$table->string('delivery', 10)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('mix');
	}

}
