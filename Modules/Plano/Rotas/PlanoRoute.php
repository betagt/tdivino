<?php
/**
 * Created by PhpStorm.
 * User: dsoft
 * Date: 06/02/2017
 * Time: 16:08
 */

namespace Modules\Plano\Rotas;

use Portal\Interfaces\ICustomRoute,
    \Route;

class PlanoRoute implements ICustomRoute
{

    public static function run()
    {
        Route::group(['prefix'=>'admin','middleware' => ['auth:api'],'namespace'=>'Api\Admin'],function (){
            Route::get('plano/por-cidade-estado/{estadoId}/{cidadeId}', [
                'as' => 'plano.show_tabela_preco',
                'uses' => 'PlanoController@showByCidadeEstado'
            ]);
            Route::group(['middleware' => ['acl'],'is' => 'administrador', 'protect_alias'  => 'user'],function (){
                Route::post('plano/tabela_preco', [
                    'as' => 'plano.cadastrar_tabela_preco',
                    'uses' => 'PlanoController@storeTabelaPreco'
                ]);
                Route::post('plano/tabela_preco', [
                    'as' => 'plano.cadastrar_tabela_preco',
                    'uses' => 'PlanoController@storeTabelaPreco'
                ]);
                Route::put('plano/tabela_preco/{id}', [
                    'as' => 'plano.alterar_tabela_preco',
                    'uses' => 'PlanoController@updateTabelaPreco'
                ]);
                Route::post('plano/tabela_preco/destroy-all', [
                    'as' => 'plano.alterar_tabela_preco',
                    'uses' => 'PlanoController@excluirPreco'
                ]);
                Route::get('plano/tabela_preco/show/{id}', [
                    'as' => 'plano.show_tabela_preco',
                    'uses' => 'PlanoController@showTabelaPreco'
                ]);
                Route::delete('plano/tabela_preco/{id}', [
                    'as' => 'plano.deletar_tabela_preco',
                    'uses' => 'PlanoController@destroyTabelaPreco'
                ]);
                Route::get('plano/tabela_preco/{plano}', [
                    'as' => 'plano.consulta_tabela_preco',
                    'uses' => 'PlanoController@indexTabelaPreco'
                ]);
                Route::resource('plano', 'PlanoController',[
                    'except' => ['create', 'edit']
                ]);
            });
        });
        Route::group(['prefix'=>'front','middleware' => ['auth:api','acl'],'is' => 'anunciante|administrador,or','namespace'=>'Api\Front'],function () {
            Route::get('plano/consulta/{tipo_anunciante}/{estado}/{cidade}', [
                'as' => 'plano.consulta_planos',
                'uses' => 'PlanoController@indexPlano'
            ]);
        });
    }
}