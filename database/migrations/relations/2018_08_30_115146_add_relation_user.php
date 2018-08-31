<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nivel_servicios',function (Blueprint $table){
            $table->integer('user_id');

            // after('id') no sirve en postgres
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Shema::table('nivel_servicios', function(Blueprint $table){
            $table->dropColumn('user_id');
        });
    }
}
