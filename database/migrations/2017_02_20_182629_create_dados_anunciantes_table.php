<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDadosAnunciantesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('dados_anunciantes', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('plano_contratacao_id')->unsigned();
            $table->foreign('plano_contratacao_id')->references('id')->on('plano_contratacaos');
            $table->enum('tipo_emitente', ['imobiliaria', 'incorporadora', 'construtora', 'autonomo']);
            $table->string('cnpj_cnpj', 14)->unique();
            $table->string('razao_social_nome', 200)->index();
            $table->string('inscricao_estadual_rg', 20)->nullable();
            $table->string('url_amigavel')->nullable();
            $table->string('creci', 15)->nullable();
            $table->boolean('endereco_diferente')->nullable();
            $table->timestamps();
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
		Schema::drop('dados_anunciantes');
	}

}
