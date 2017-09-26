<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnderecosTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('enderecos', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('estado_id')->unsigned();
            $table->integer('cidade_id')->unsigned();
            $table->integer('bairro_id')->unsigned();
            $table->integer('enderecotable_id')->nullable();
            $table->string('enderecotable_type')->nullable();
            $table->string('cep', 20);
            $table->string('numero', 10);
            $table->string('endereco', 200);
            $table->string('complemento', 200)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('estado_id')->references('id')->on('estados');
            $table->foreign('cidade_id')->references('id')->on('cidades');
            $table->foreign('bairro_id')->references('id')->on('bairros');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('enderecos');
	}

}
