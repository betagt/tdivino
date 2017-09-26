<?php
/**
 * Created by PhpStorm.
 * User: dsoft
 * Date: 06/02/2017
 * Time: 15:58
 */

namespace Modules\Transporte\Rotas;

use Portal\Interfaces\ICustomRoute;
use \Route;

class VeiculoRoute implements ICustomRoute
{

    public static function run()
    {
        Route::group(['prefix'=>'admin','middleware' => ['auth:api'],'namespace'=>'Api\Admin'],function () {
            Route::group(['middleware' => ['acl'],'is' => 'administrador|fornecedor', 'protect_alias'  => 'user'],function (){
                Route::post('veiculo/user-cadastro', [
                    'as' => 'veiculo.user-cadastro',
                    'uses' => 'VeiculoController@veiculocadastro'
                ]);
                Route::post('veiculo/atualizar-cadastro/{id}', [
                    'as' => 'veiculo.user-cadastro',
                    'uses' => 'VeiculoController@updateImageVeiculo'
                ]);
                Route::get('veiculo/meus-veiculos', [
                    'as' => 'veiculo.meus-veiculos',
                    'uses' => 'VeiculoController@todosByUser'
                ]);
                Route::get('veiculo/cores', [
                    'as' => 'veiculo.cores',
                    'uses' => 'VeiculoController@cores'
                ]);
            });
            Route::group(['middleware' => ['acl'],'is' => 'administrador|moderador,or', 'protect_alias'  => 'user'],function (){
                Route::resource('veiculo', 'VeiculoController',
                    [
                        'except' => ['create', 'edit']
                    ]);
            });
        });
    }
}