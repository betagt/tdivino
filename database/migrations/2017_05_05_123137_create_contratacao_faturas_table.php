<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContratacaoFaturasTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contratacao_faturas', function(Blueprint $table) {
            $table->increments('id');
            $table->string('razaosocial');
            $table->integer('plano_contratacao_id')->unsigned();
            $table->foreign('plano_contratacao_id')->references('id')->on('plano_contratacaos');
            $table->enum('tipo_emitente',['imobiliaria','incorporadora','construtora','autonomo']);
            $table->string('cpf_cnpj');
            $table->string('nomefantazia')->nullable();
            $table->string('inscricao_estadual')->nullable();
            $table->string('creci')->nullable();
            $table->boolean('endereco_diferente')->default(false);
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
		Schema::drop('contratacao_faturas');
	}

}
