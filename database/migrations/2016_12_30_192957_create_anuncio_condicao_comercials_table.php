<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnuncioCondicaoComercialsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('anuncio_condicao_comercials', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('anuncio_id')->unsigned();
            $table->foreign('anuncio_id')->references('id')->on('anuncios');
            $table->boolean('aceita_permuta')->nullable();
            $table->boolean('aceita_permuta_carro')->nullable();
            $table->boolean('aceita_permuta_imovel')->nullable();
            $table->boolean('aceita_permuta_outro')->nullable();
            $table->decimal('valor_permuta_carro', 15, 2)->nullable();
            $table->decimal('valor_permuta_imovel', 15, 2)->nullable();
            $table->decimal('valor_permuta_outro', 15, 2)->nullable();
            $table->string('descricao_permuta')->nullable();
            $table->decimal('valor_mensal', 15, 2);
            $table->decimal('valor_entrada', 15, 2);
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
		Schema::drop('anuncio_condicao_comercials');
	}

}
