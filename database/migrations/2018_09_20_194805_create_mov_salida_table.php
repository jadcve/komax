    <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMovSalidaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mov_salida', function(Blueprint $table)
		{
			$table->date('fecha')->nullable();
			$table->string('tienda', 20)->nullable();
			$table->string('bodega', 50)->nullable();
			$table->string('invoice_id', 15)->nullable();
			$table->string('salesid', 20)->nullable();
			$table->string('sku', 50)->nullable();
			$table->string('itemid', 50)->nullable();
			$table->string('cod_talla', 20)->nullable();
			$table->bigInteger('qty')->nullable();
			$table->bigInteger('unit_price_ivaincl')->nullable();
			$table->bigInteger('netamount')->nullable();
			$table->bigInteger('precioneto')->nullable();
			$table->bigInteger('tax_amount')->nullable();
			$table->bigInteger('line_amount')->nullable();
			$table->string('invoice_account', 50)->nullable();
			$table->string('invoicing_name', 50)->nullable();
			$table->string('sales_documentcode', 20)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('mov_salida');
	}

}
