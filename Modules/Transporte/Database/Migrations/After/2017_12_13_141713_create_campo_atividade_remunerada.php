<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampoAtividadeRemunerada extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('transporte_documentos', function (Blueprint $table) {
            $table->boolean('atividade_remunerada')->default(false)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		if (Schema::hasColumn('transporte_documentos', 'atividade_remunerada')) {
			Schema::table('transporte_tipo_documentos', function (Blueprint $table) {
				$table->dropColumn('atividade_remunerada');
			});
		}
    }
}
