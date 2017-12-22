<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContatoETelefone extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('pessoas', function (Blueprint $table) {
			$table->string('contato_segudo')->nullable();
			$table->string('telefone_contato')->nullable();
			$table->string('telefone_segundo_contato')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		if (Schema::hasColumn('pessoas', 'contato_segudo')) {
			Schema::table('pessoas', function (Blueprint $table) {
				$table->dropColumn('contato_segudo');
				$table->dropColumn('telefone_contato');
				$table->dropColumn('telefone_segundo_contato');
			});
		}
	}
}
