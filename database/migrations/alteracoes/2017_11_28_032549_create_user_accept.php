<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAccept extends Migration
{
    public function up()
    {

        Schema::table('users', function (Blueprint $table) {
            $table->boolean('aceita_termos')->nullable()->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('users', 'aceita_termos')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('aceita_termos');
            });
        }
    }
}
