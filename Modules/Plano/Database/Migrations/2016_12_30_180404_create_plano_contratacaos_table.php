<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanoContratacaosTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('plano_contratacaos', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('plano_id')->unsigned();
            $table->foreign('plano_id')->references('id')->on('planos');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('numero_fatura')->unique()->nullable();
            $table->date('data_inicio');
            $table->date('data_fim');
            $table->decimal('total', 15, 2);
            $table->decimal('desconto', 15, 2)->default(0);
            $table->enum('status',['ativo', 'inativo', 'cancelado', 'pendente', 'finalizado'])->default('pendente');
            /*$table->integer('plano_contratacaotable_id');
            $table->string('plano_contratacaotable_type');*/
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
		Schema::drop('plano_contratacaos');
	}

}
