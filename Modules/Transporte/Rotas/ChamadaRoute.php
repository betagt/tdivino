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
		Route::get('admin/chamada/teste-moip', [
			'as' => 'chamda.teste-moip',
			'uses' => 'Api\Admin\ChamadaController@moipTeste'
		]);
        Route::group(['prefix'=>'admin','middleware' => ['auth:api'],'namespace'=>'Api\Admin'],function () {
            Route::group(['middleware' => ['acl'],'is' => 'administrador|fornecedor|taxista|mototaxista|cliente', 'protect_alias'  => 'user'],function (){
                Route::get('chamada/cliente-chamadas', [
                    'as' => 'chamda.atender',
                    'uses' => 'ChamadaController@listarByCliente'
                ]);
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
                Route::post('chamada/calcular-rota', [
                    'as' => 'chamda.cancelar',
                    'uses' => 'ChamadaController@calcularRota'
                ]);
            });
            Route::group(['middleware' => ['acl'],'is' => 'administrador|fornecedor|taxista|mototaxista', 'protect_alias'  => 'user'],function (){
                Route::post('chamada/atender/{idChamada}', [
                    'as' => 'chamda.atender',
                    'uses' => 'ChamadaController@atender'
                ]);
                Route::get('chamada/embarque/{idChamada}', [
                    'as' => 'chamda.atender',
                    'uses' => 'ChamadaController@embarquePassageiro'
                ]);
                Route::get('chamada/minhas-chamadas', [
                    'as' => 'chamda.atender',
                    'uses' => 'ChamadaController@listarByFornecedor'
                ]);
                Route::get('chamada/desembarque/{idChamada}', [
                    'as' => 'chamda.atender',
                    'uses' => 'ChamadaController@desembarquePassageiro'
                ]);
                Route::get('chamada/visualizar-fornecedor/{id}', [
                    'as' => 'chamda.cancelar',
                    'uses' => 'ChamadaController@visualizarFornecedor'
                ]);
                Route::post('chamada/cancelar-fornecedor/{idChamada}', [
                    'as' => 'chamda.cancelar-fornecedor',
                    'uses' => 'ChamadaController@cancelarForcedor'
                ]);
                Route::get('chamada/sinal-motorista/{idChamada}', [
                    'as' => 'chamda.cancelar-fornecedor',
                    'uses' => 'ChamadaController@motoristaNoLocal'
                ]);
                Route::get('chamada/chamadas-ativas', [
                    'as' => 'chamda.cancelar-fornecedor',
                    'uses' => 'ChamadaController@listaChamadasAtivas'
                ]);
            });
            Route::group(['middleware' => ['acl'],'is' => 'administrador|agencia-reguladora|moderator,or', 'protect_alias'  => 'user'],function (){
                Route::get('chamada/chamadas-agencia/{id}', [
                    'as' => 'chamda.atender',
                    'uses' => 'ChamadaController@listarByFornecedorAgencia'
                ]);
            });
            Route::group(['middleware' => ['acl'],'is' => 'administrador|moderador,or', 'protect_alias'  => 'user'],function (){
                Route::get('chamada/monitor-chamadas', [
                    'as' => 'chamda.monitor.chamadas',
                    'uses' => 'ChamadaController@monitoChamadas'
                ]);
                Route::resource('veiculo', 'VeiculoController',
                    [
                        'except' => ['create', 'edit']
                    ]);
                Route::resource('chamada', 'ChamadaController',
                    [
                        'except' => ['create', 'edit']
                    ]);
            });
        });
    }
}