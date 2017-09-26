<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinalidadeCaracteristicasTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('finalidade_caracteristicas', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('finalidade_id')->unsigned();
            $table->foreign('finalidade_id')->references('id')->on('finalidades');
            $table->integer('caracteristica_id')->unsigned();
            $table->foreign('caracteristica_id')->references('id')->on('caracteristicas');
            $table->unique(['finalidade_id', 'caracteristica_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('finalidade_caracteristicas');
	}

}
