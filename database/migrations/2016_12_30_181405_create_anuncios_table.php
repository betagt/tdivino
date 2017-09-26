<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnunciosTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('anuncios', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('plano_contratacao_id')->unsigned()->nullable();
            $table->foreign('plano_contratacao_id')->references('id')->on('plano_contratacaos');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('finalidade_id')->unsigned();
            $table->foreign('finalidade_id')->references('id')->on('finalidades');
            $table->decimal('valor', 15, 2);
            $table->decimal('valor_condominio', 15, 2)->nullable();
            $table->enum('pretensao', ['Alugar', 'Vender', 'Revender', 'Lancamento']);
            $table->string('codigo')->unique()->nullable();
            $table->text('descricao');
            $table->integer('anunciotable_id')->nullable();
            $table->string('anunciotable_type')->nullable();
            $table->integer('ano_construcao')->nullable();
            $table->timestamp('remove_site_view')->nullable();
            $table->text('observacao')->nullable();
            $table->text('caracteristica_extra')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();

            //imovel
            $table->double('area_util')->nullable();
            $table->double('area_total')->nullable();
            $table->integer('qtde_dormitorio')->nullable();
            $table->integer('qtde_suite')->nullable();
            $table->integer('qtde_banheiro')->nullable();
            $table->integer('qtde_vaga')->nullable();
            $table->integer('qtde_sala')->nullable();
            $table->boolean('possui_divida')->nullable();
            $table->decimal('saldo_divida', 15, 2)->nullable();
            $table->decimal('valor_mensalidade_divida', 15, 2)->nullable();
            $table->date('data_vencimento_divida')->nullable();
            $table->date('data_ultima_parcela_divida')->nullable();
            $table->integer('qtde_parcela_restante_divida')->nullable();

            //Empreendimento
            $table->string('titulo')->index();
            $table->string('titulo_reduzido')->nullable();
            $table->string('subtitulo')->nullable();
            $table->text('descricao_curta')->nullable();
            $table->double('qtde_area_maximo')->nullable();
            $table->double('qtde_area_minimo')->nullable();
            $table->integer('qtde_dormitoario_maximo')->nullable();
            $table->integer('qtde_dormitoario_minimo')->nullable();
            $table->integer('qtde_suite_maximo')->nullable();
            $table->integer('qtde_suite_minimo')->nullable();
            $table->integer('qtde_andar')->nullable();
            $table->integer('qtde_elevador')->nullable();
            $table->integer('qtde_unidade_andar')->nullable();
            $table->string('tour_virtual')->nullable();
            $table->string('video')->nullable();
            $table->string('informacao_complementar')->nullable();
            $table->string('descricao_localizacao')->nullable();
            $table->enum('situacao', ['na-planta', 'em-obras', 'pronto'])->nullable();
            $table->enum('tipo', ['imovel', 'empreendimento']);
            $table->boolean('status');
            $table->boolean('score')->default(0);
            $table->softDeletes();
            $table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('anuncios');
	}

}
