<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColumnUsersPessoaId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('users', function (Blueprint $table) {
			$table->integer('pessoa_id')->unsigned()->nullable()->index();
			$table->foreign('pessoa_id')->references('id')->on('pessoas');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		if (Schema::hasColumn('users', 'pessoa_id')) {
			Schema::table('users', function (Blueprint $table) {
				$table->dropForeign('users_pessoa_id_foreign');
				$table->dropColumn('pessoa_id');
			});
		}
    }
}
