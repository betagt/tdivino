<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransporteModeloCarrosTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('transporte_modelo_carros', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('transporte_marca_carro_id')->unsigned()->nullable();
            $table->foreign('transporte_marca_carro_id')->references('id')->on('transporte_marca_carros');
            $table->string('nome');
            $table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('transporte_modelo_carros');
	}

}
