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

class ChamadaRoute implements ICustomRoute
{

    public static function run()
    {
        Route::group(['prefix'=>'admin','middleware' => ['auth:api'],'namespace'=>'Api\Admin'],function () {
            Route::group(['middleware' => ['acl'],'is' => 'administrador|fornecedor|cliente', 'protect_alias'  => 'user'],function (){
                Route::post('chamada/iniciar-chamada', [
                    'as' => 'chamda.iniciar-chamada',
                    'uses' => 'ChamadaController@iniciarChamada'
                ]);
                Route::get('chamada/cancelar/{id}', [
                    'as' => 'chamda.cancelar',
                    'uses' => 'ChamadaController@cancelar'
                ]);
                Route::get('chamada/visualizar/{id}', [
                    'as' => 'chamda.cancelar',
                    'uses' => 'ChamadaController@visualizar'
                ]);
                Route::post('chamada/avaliacao/{id}', [
                    'as' => 'chamda.avaliacao',
                    'uses' => 'ChamadaController@avaliacao'
                ]);
            });
            Route::group(['middleware' => ['acl'],'is' => 'administrador|fornecedor', 'protect_alias'  => 'user'],function (){
                Route::post('chamada/atender/{idChamada}', [
                    'as' => 'chamda.atender',
                    'uses' => 'ChamadaController@atender'
                ]);
                Route::get('chamada/embarque/{idChamada}', [
                    'as' => 'chamda.atender',
                    'uses' => 'ChamadaController@embarquePassageiro'
                ]);
                Route::get('chamada/desembarque/{idChamada}', [
                    'as' => 'chamda.atender',
                    'uses' => 'ChamadaController@desembarquePassageiro'
                ]);
                Route::get('chamada/visualizar-fornecedor/{id}', [
                    'as' => 'chamda.cancelar',
                    'uses' => 'ChamadaController@visualizarFornecedor'
                ]);
                Route::get('chamada/cancelar-fornecedor/{idChamada}', [
                    'as' => 'chamda.cancelar-fornecedor',
                    'uses' => 'ChamadaController@cancelarForcedor'
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