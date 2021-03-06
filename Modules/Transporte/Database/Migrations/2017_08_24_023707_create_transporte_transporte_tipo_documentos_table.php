<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransporteTransporteTipoDocumentosTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transporte_tipo_documentos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->string('observacao')->nullable();
            $table->boolean('precisa_de_documento')->default(true);
            $table->enum('tipo', ['pessoa', 'veiculo']);
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
        Schema::drop('transporte_tipo_documentos');
    }

}
