<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGidTransitoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('transito', function(Blueprint $table)
		{
			$table->string('bodega_desde', 10)->nullable();
			$table->string('bodega_hasta', 10)->nullable();
			$table->string('transferid', 10)->nullable();
			$table->bigInteger('status')->nullable();
			$table->string('transfer_status_description', 7)->nullable();
			$table->string('sku', 50)->nullable();
			$table->bigInteger('line_no')->nullable();
			$table->bigInteger('qty_requested')->nullable();
			$table->bigInteger('qty_shipped')->nullable();
			$table->bigInteger('qty_received')->nullable();
			$table->date('fecha_creacion')->nullable();
			$table->date('fecha_solicitud_envio')->nullable();
			$table->date('fecha_envio')->nullable();
			$table->date('fecha_recepcion')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('transito');
	}

}
