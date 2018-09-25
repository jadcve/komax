<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCalculosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('calculos', function(Blueprint $table)
		{
			$table->string('warehouse', 50)->nullable();
			$table->text('tienda')->nullable();
			$table->string('alm_art', 30)->nullable();
			$table->string('articlecode', 50)->nullable();
			$table->decimal('ordercicle', 10, 0)->nullable();
			$table->bigInteger('stockonhand')->nullable();
			$table->bigInteger('stockonhandcd')->nullable();
			$table->float('orderlevel', 10, 0)->nullable();
			$table->decimal('stockonorder', 10, 0)->nullable();
			$table->float('roundedorderquantity', 10, 0)->nullable();
			$table->float('maxstockrounded', 10, 0)->nullable();
			$table->decimal('wk', 10, 0)->nullable();
			$table->decimal('demand1', 10, 0)->nullable();
			$table->decimal('demand2', 10, 0)->nullable();
			$table->decimal('demand3', 10, 0)->nullable();
			$table->decimal('demand4', 10, 0)->nullable();
			$table->decimal('demand5', 10, 0)->nullable();
			$table->decimal('demand6', 10, 0)->nullable();
			$table->decimal('demand7', 10, 0)->nullable();
			$table->decimal('demanad8', 10, 0)->nullable();
			$table->float('ava_cd_ship', 10, 0)->nullable();
			$table->text('almacen_origen')->nullable();
			$table->string('almacen_destino', 50)->nullable();
			$table->integer('tipo_pedido')->nullable();
			$table->text('estilo_color')->nullable();
			$table->text('talla')->nullable();
			$table->text('marca')->nullable();
			$table->date('fecha_despacho')->nullable();
			$table->float('cantidad', 10, 0)->nullable();
			$table->decimal('transito', 10, 0)->nullable();
			$table->string('delivery', 10)->nullable();
			$table->float('minimo', 10, 0)->nullable();
			$table->text('temporada')->nullable();
			$table->text('familia')->nullable();
			$table->text('sub_familia')->nullable();
			$table->text('categoria')->nullable();
			$table->bigInteger('pvp')->nullable();
			$table->text('codigo_talla')->nullable();
			$table->text('codigo_color')->nullable();
			$table->text('area')->nullable();
			$table->text('descripcion')->nullable();
			$table->decimal('todos', 10, 0)->nullable();
			$table->decimal('todosall', 10, 0)->nullable();
			$table->decimal('todosant', 10, 0)->nullable();
			$table->decimal('p1', 10, 0)->nullable();
			$table->decimal('p2', 10, 0)->nullable();
			$table->decimal('calculo', 10, 0)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('calculos');
	}

}
