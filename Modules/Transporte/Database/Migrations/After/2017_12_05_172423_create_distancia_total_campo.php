<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistanciaTotalCampo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('transporte_chamadas', function (Blueprint $table) {
			$table->double('km_rodado')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		if (Schema::hasColumn('transporte_chamadas', 'km_rodado')) {
			Schema::table('transporte_chamadas', function (Blueprint $table) {
				$table->dropColumn('km_rodado');
			});
		}
    }
}
