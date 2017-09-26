<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChamadasTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('transporte_chamadas', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('fornecedor_id')->unsigned();
            $table->foreign('fornecedor_id')->references('id')->on('users');
            $table->integer('cliente_id')->unsigned();
            $table->foreign('cliente_id')->references('id')->on('users');
            $table->integer('forma_pagamento_id')->unsigned();
            $table->foreign('forma_pagamento_id')->references('id')->on('forma_pagamentos');
            $table->enum('tipo',['solicitacao', 'atendimento'])->default('solicitacao')->description('o tipo da chamada muda quando o taxista atende o chamado');
            $table->double('desolamento_km_com_passageiro')->description('deslocamento sem o passageiro');
            $table->double('desolamento_km_sem_passageiro')->description('deslocamento com o passageiro');
            $table->dateTime('datahora_chamado')->description('hora que o cliente iniciou o chamdo');
            $table->dateTime('datahora_comfirmação')->description('hora que taxista aceitou o chamado ');
            $table->dateTime('datahora_embarque')->description('hora que o cliente embarcou');
            $table->dateTime('datahora_desembarcou')->description('hora que o cliente desembarcou');
            $table->double('valor');
            $table->string('observacao');
            $table->integer('porta_mala')->nullable();
            $table->string('cupon')->nullable();
            $table->dateTime('data_inicial')->nullable();
            $table->dateTime('data_final')->nullable();
            $table->dateTime('timedown')->nullable()->description('contagem de tempo para finalização da chamada');
            $table->enum('status',['pendente', 'pago', 'cancelado'])->default('solicitacao')->description('o tipo da chamada muda quando o taxista atende o chamado');
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
		Schema::drop('transporte_chamadas');
	}

}
