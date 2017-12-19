<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampoTipoSanquineo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('pessoas', function (Blueprint $table) {
            $table->enum('tipo_sanguineo', ['A', 'B', 'AB', 'O'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		if (Schema::hasColumn('pessoas', 'tipo_sanguineo')) {
			Schema::table('pessoas', function (Blueprint $table) {
				$table->dropColumn('tipo_sanguineo');
			});
		}
    }
}
