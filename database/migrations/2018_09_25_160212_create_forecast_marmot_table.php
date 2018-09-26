<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateForecastMarmotTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('forecast_marmot', function(Blueprint $table)
		{
			$table->string('cod_art')->nullable();
			$table->float('score_m1', 10, 0)->nullable();
			$table->float('score_11', 10, 0)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('forecast_marmot');
	}

}
