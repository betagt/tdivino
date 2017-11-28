<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCamposTempoDeCancelamento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('configuracaos', function (Blueprint $table) {
            $table->integer('tempo_cancel_fornecedor_min')->nullable()->default(0);
            $table->integer('tempo_cancel_cliente_min')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('configuracaos', 'tempo_cancel_fornecedor_min')) {
            Schema::table('configuracaos', function (Blueprint $table) {
                $table->dropColumn('tempo_cancel_fornecedor_min');
                $table->dropColumn('tempo_cancel_cliente_min');
            });
        }
    }
}
