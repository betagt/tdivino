<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanosTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('planos', function(Blueprint $table) {
            $table->increments('id');
            $table->string('nome')->index();
            $table->integer('dias');
            $table->integer('qtde_destaque')->default(1);
            $table->integer('qtde_anuncio')->default(1);
            $table->decimal('valor', 15, 2);
            $table->enum('tipo', ['anunciante', 'imobiliaria', 'qimob-erp']);
            $table->boolean('status')->nullable();
            $table->unique(['nome', 'tipo']);
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
		Schema::drop('planos');
	}

}
