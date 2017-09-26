<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLancamentosTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lancamentos', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('plano_contratacao_id')->unsigned();
            $table->foreign('plano_contratacao_id')->references('id')->on('plano_contratacaos');
            $table->integer('forma_pagamento_id')->unsigned();
            $table->foreign('forma_pagamento_id')->references('id')->on('forma_pagamentos');
            $table->string('codigo')->nullable();
            $table->string('metodo');
            $table->string('link_externo');
            $table->dateTime('ultima_atualizacao')->nullable();
            $table->integer('status');
            $table->double('valor');
            $table->double('valor_liquido');
            $table->double('taxa');
            $table->double('desconto')->default(0)->nullable();
            $table->date('data_do_pagamento')->nullable();
            $table->softDeletes();
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
		Schema::drop('lancamentos');
	}

}
