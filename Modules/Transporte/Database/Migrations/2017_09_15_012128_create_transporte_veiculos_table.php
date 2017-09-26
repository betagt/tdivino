<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransporteVeiculosTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('transporte_veiculos', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('transporte_marca_carro_id')->unsigned()->nullable();
            $table->foreign('transporte_marca_carro_id')->references('id')->on('transporte_marca_carros');
            $table->integer('transporte_modelo_carro_id')->unsigned()->nullable();
            $table->foreign('transporte_modelo_carro_id')->references('id')->on('transporte_modelo_carros');
            $table->string('placa');
            $table->text('observacao')->nullale();
            $table->integer('num_passageiro')->nullale();
            $table->integer('ano');
            $table->integer('ano_modelo_fab')->nullale();
            $table->string('cor');
            $table->string('renavam')->nullale();
            $table->date('data_licenciamento');
            $table->string('tipo_combustivel')->nullale();
            $table->string('consumo_medio')->nullale();
            $table->string('chassi')->nullale();
            $table->string('porta_mala_tamanho')->nullale();
            $table->string('arquivo');
            $table->string('status');
            $table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('transporte_veiculos');
	}

}
