<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColumnUsersLatLngDocumentosValidate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

		Schema::table('users', function (Blueprint $table) {
			$table->double('lat')->nullable();
			$table->double('lng')->nullable();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		if (Schema::hasColumn('users', 'lat')) {
			Schema::table('users', function (Blueprint $table) {
				$table->dropColumn('lat');
				$table->dropColumn('lng');
			});
		}
    }
}
