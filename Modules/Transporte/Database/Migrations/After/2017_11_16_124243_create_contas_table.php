<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContasTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('transporte_contas', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->nullable()->unsigned()->nullable();
			$table->foreign('user_id')->references('id')->on('users');
			$table->integer('codigo');
			$table->string('agencia');
			$table->string('conta');
			$table->string('variacao')->nullable();
			$table->enum('tipo', ['cc', 'cp'])->default('cc');
			$table->string('beneficiario')->nullable();
			$table->string('cpf')->nullable();
			$table->boolean('principal')->default(false);
			$table->enum('status', ['ativa', 'pendente', 'cancelada'])->default('pendente');
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
		Schema::drop('transporte_contas');
	}

}
