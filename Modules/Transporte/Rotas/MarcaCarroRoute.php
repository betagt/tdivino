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

class MarcaCarroRoute implements ICustomRoute
{

    public static function run()
    {
        Route::group(['prefix'=>'admin','middleware' => ['auth:api'],'namespace'=>'Api\Admin'],function () {
            Route::group(['middleware' => ['acl'],'is' => 'administrador|fornecedor|taxista|mototaxista', 'protect_alias'  => 'user'],function (){
                Route::get('marca-carro/todos', [
                    'as' => 'marcaCarro.todos',
                    'uses' => 'MarcaCarroController@todos'
                ]);
            });
            Route::group(['middleware' => ['acl'],'is' => 'administrador|moderador,or', 'protect_alias'  => 'user'],function (){
                Route::resource('marca-carro', 'MarcaCarroController',
                    [
                        'except' => ['create', 'edit']
                    ]);
            });
        });
    }
}