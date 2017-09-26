<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuscaAlertasTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('busca_alertas', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('url');
            $table->string('titulo', 200);
            $table->string('nome');
            $table->boolean('ativar_alarme')->nullable();
            $table->string('email')->nullable();
            $table->enum('tipo_frequencia', ['diario', 'mensal'])->nullable();
            $table->integer('horario')->nullable();
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
		Schema::drop('busca_alertas');
	}

}
