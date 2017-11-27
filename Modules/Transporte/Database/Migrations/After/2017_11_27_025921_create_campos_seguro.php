<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCamposSeguro extends Migration
{
    public function up()
    {

        Schema::table('transporte_documentos', function (Blueprint $table) {
            $table->string('seguradora')->nullable();
            $table->enum('cobertura_de_vidas', ['sim', 'nao'])->nullable();
            $table->enum('cobertura_de_terceiros', ['sim', 'nao'])->nullable();
            $table->date('vencimento')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('transporte_documentos', 'cobertura_de_vidas')) {
            Schema::table('transporte_documentos', function (Blueprint $table) {
                $table->dropColumn('cobertura_de_vidas');
                $table->dropColumn('cobertura_de_terceiros');
                $table->dropColumn('vencimento');
                $table->dropColumn('seguradora');
            });
        }
    }
}
