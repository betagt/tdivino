<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AnuncioRemoveContraint extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('anuncios', function (Blueprint $table) {
            $table->dropForeign('anuncios_plano_contratacao_id_foreign');
            $table->dropColumn('plano_contratacao_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('anuncios', function (Blueprint $table) {
            $table->integer('plano_contratacao_id')->unsigned()->nullable();
            $table->foreign('plano_contratacao_id')->references('id')->on('plano_contratacaos');
        });
    }
}
