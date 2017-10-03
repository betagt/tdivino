<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeoPosicaosTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('transporte_geo_posicaos', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('transporte_geo_posicaotable_id')->nullable();
            $table->string('transporte_geo_posicaotable_type')->nullable();
            $table->string('endereco')->nullable();
            $table->double('lat');
            $table->double('lng');
            $table->boolean('passageiro')->nullable();
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
		Schema::drop('transporte_geo_posicaos');
	}

}
