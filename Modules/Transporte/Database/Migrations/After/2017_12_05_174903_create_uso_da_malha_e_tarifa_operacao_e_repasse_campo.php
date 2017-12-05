<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsoDaMalhaETarifaOperacaoERepasseCampo extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('transporte_chamadas', function (Blueprint $table) {
			$table->double('tx_uso_malha')->nullable()->default(0);
			$table->double('tarifa_operacao')->nullable()->default(0);
			$table->double('valor_repasse')->nullable()->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		if (Schema::hasColumn('transporte_chamadas', 'tx_uso_malha')) {
			Schema::table('transporte_chamadas', function (Blueprint $table) {
				$table->dropColumn('tx_uso_malha');
				$table->dropColumn('tarifa_operacao');
				$table->dropColumn('valor_repasse');
			});
		}
	}
}
