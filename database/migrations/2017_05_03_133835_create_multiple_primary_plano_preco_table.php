<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMultiplePrimaryPlanoPrecoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plano_tabela_precos', function(Blueprint $table) {
            $table->primary(array('id','plano_id', 'cidade_id', 'estado_id'));

            //DB::statement('ALTER TABLE spins MODIFY rid INTEGER NOT NULL AUTO_INCREMENT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plano_tabela_precos', function(Blueprint $table) {
            $table->dropPrimary('id');
            $table->dropPrimary('plano_id');
            $table->dropPrimary('cidade_id');
            $table->dropPrimary('estado_id');
        });
    }
}
