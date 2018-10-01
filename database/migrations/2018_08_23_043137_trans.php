<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class Trans.
 *
 * @author  The scaffold-interface created at 2018-08-23 04:31:37pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class Trans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('trans',function (Blueprint $table){

        $table->increments('id');
        $table->date('fecha');
        $table->String('cod_art');
        $table->String('sku');
        $table->String('bodega');
        $table->String('agrupacion1');
        $table->integer('unit_price_ivaincl');
        $table->integer('netamount');
        $table->integer('precioneto');
        $table->integer('tax_amount');
        $table->integer('line_amount');
        $table->String('codigo_color');
        $table->String('codigo_talla');
        $table->integer('precio_iva_incl');
        $table->integer('costo');
        $table->String('marca');
        $table->String('area');
        $table->String('linea');
        $table->String('negocio');
        $table->String('division');
        $table->String('familia');
        $table->String('categoria');
        $table->integer('qty');

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
        Schema::drop('trans');
    }
}
