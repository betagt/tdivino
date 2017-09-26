<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDadosAnuncianteContatosTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('dados_anunciante_contatos', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('dados_anunciante_id')->unsigned();
            $table->foreign('dados_anunciante_id')->references('id')->on('dados_anunciantes');
            $table->string('nome', 200)->index();
            $table->string('email');
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
		Schema::drop('dados_anunciante_contatos');
	}

}
