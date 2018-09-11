<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStockTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('stock', function(Blueprint $table)
		{
			$table->string('fecha')->nullable();
			$table->string('bodega', 100)->nullable();
			$table->string('sku', 100)->nullable();
			$table->bigInteger('precio_iva_incluido')->nullable();
			$table->bigInteger('costo')->nullable();
			$table->bigInteger('cantidad')->nullable();
			$table->bigInteger('stock_valorizado')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('stock');
	}

}
