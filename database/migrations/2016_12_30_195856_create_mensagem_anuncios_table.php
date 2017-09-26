<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMensagemAnunciosTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mensagem_anuncios', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('anuncio_id')->unsigned();
            $table->foreign('anuncio_id')->references('id')->on('anuncios');
            $table->string('nome');
            $table->string('email');
            $table->integer('ddd');
            $table->string('telefone');
            $table->text('texto');
            $table->boolean('status')->default(false);
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
		Schema::drop('mensagem_anuncios');
	}

}
