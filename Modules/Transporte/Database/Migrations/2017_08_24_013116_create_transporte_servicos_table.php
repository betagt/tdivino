<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransporteServicosTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('transporte_servicos', function(Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->string('nome_similar');
            //$table->string('grupo_do_servico')->nullable();
            //$table->string('area_do_servico')->nullable();
            //$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('transporte_servicos');
	}

}
