<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColumnUsersCalculoFieldsValidate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

		Schema::table('configuracaos', function (Blueprint $table) {
			$table->double('vlbas')->nullable()->default(0);
			$table->double('vlkm')->nullable()->default(0);
			$table->double('vlmin')->nullable()->default(0);
			$table->double('vlsegp')->nullable()->default(0);
			$table->double('vlkmr')->nullable()->default(0);
			$table->double('nmkm')->nullable()->default(0);
			$table->double('nmmin')->nullable()->default(0);
			$table->double('pkmm')->nullable()->default(0);
			$table->double('ptxoper')->nullable()->default(0);
			$table->double('bonusm')->nullable()->default(0);
			$table->double('vltgo')->nullable()->default(0);
			$table->double('vlapseg')->nullable()->default(0);
			$table->double('vlbonusp')->nullable()->default(0);
			$table->double('pbonusp')->nullable()->default(0);
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		if (Schema::hasColumn('configuracaos', 'vlbas')) {
			Schema::table('configuracaos', function (Blueprint $table) {
				$table->dropColumn('vlbas');
				$table->dropColumn('vlkm');
				$table->dropColumn('vlmin');
				$table->dropColumn('vlsegp');
				$table->dropColumn('vlkmr');
				$table->dropColumn('nmkm');
				$table->dropColumn('nmmin');
				$table->dropColumn('pkmm');
				$table->dropColumn('ptxoper');
				$table->dropColumn('bonusm');
				$table->dropColumn('vltgo');
				$table->dropColumn('vlapseg');
				$table->dropColumn('vlbonusp');
				$table->dropColumn('pbonusp');
			});
		}
    }
}
