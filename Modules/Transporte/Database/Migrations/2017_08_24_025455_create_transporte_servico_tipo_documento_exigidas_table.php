<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransporteServicoTipoDocumentoExigidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transporte_servico_tipo_documento_exigidas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('servico_id')->unsigned()->index()->foreign()->references("id")->on("transporte_servicos")->onDelete("cascade");
            $table->integer('tipo_documento_id')->unsigned()->index()->foreign()->references("id")->on("transporte_tipo_documentos")->onDelete("cascade");
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
        Schema::dropIfExists('transporte_servico_tipo_documento_exigidas');
    }
}
