<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransporteDocumentosTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('transporte_documentos', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('documentotable_id');
            $table->string('documentotable_type');
            $table->integer('transporte_tipo_documento_id')->unsigned()->nullable();
            $table->foreign('transporte_tipo_documento_id')->references('id')->on('transporte_tipo_documentos');
            $table->string('nome')->nullable();
            $table->string('arquivo');
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
		Schema::drop('transporte_documentos');
	}

}
