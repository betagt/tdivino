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

class TipoDocumentoRoute implements ICustomRoute
{

    public static function run()
    {
        Route::group(['prefix'=>'admin','middleware' => ['auth:api'],'namespace'=>'Api\Admin'],function () {
            Route::group(['middleware' => ['acl'],'is' => 'administrador|fornecedor|taxista|mototaxista', 'protect_alias'  => 'user'],function (){
                Route::get('tipo-documento/todos', [
                    'as' => 'habilidade.todos',
                    'uses' => 'TipoDocumentoController@todos'
                ]);
                Route::get('tipo-documento/todos-pessoa', [
                    'as' => 'habilidade.todos',
                    'uses' => 'TipoDocumentoController@pessoa'
                ]);
                Route::get('tipo-documento/todos-veiculo', [
                    'as' => 'habilidade.todos.pessoa',
                    'uses' => 'TipoDocumentoController@veiculo'
                ]);
            });
            Route::group(['middleware' => ['acl'],'is' => 'administrador|moderador,or', 'protect_alias'  => 'user'],function (){
                Route::resource('tipo-documento', 'TipoDocumentoController',
                    [
                        'except' => ['create', 'edit']
                    ]);
            });
        });
    }
}