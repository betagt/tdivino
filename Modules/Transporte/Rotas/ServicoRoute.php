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

class ServicoRoute implements ICustomRoute
{

    public static function run()
    {
        Route::group(['prefix'=>'admin','middleware' => ['auth:api'],'namespace'=>'Api\Admin'],function () {
            Route::group(['middleware' => ['acl'],'is' => 'administrador|moderador|fornecedor|taxista|mototaxista', 'protect_alias'  => 'user'],function (){
                Route::get('servico/servico-ativo', [
                    'as' => 'servico.servico-ativo',
                    'uses' => 'ServicoController@servicoAtivo',
                ]);
            });
            Route::group(['middleware' => ['acl'],'is' => 'administrador|moderador', 'protect_alias'  => 'user'],function (){
                Route::resource('servico', 'ServicoController',
                    [
                        'except' => ['create', 'edit']
                    ]);
            });
        });
    }
}