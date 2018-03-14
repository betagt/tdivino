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

class FinanceiroContaRoute implements ICustomRoute
{

    public static function run()
    {
        Route::group(['prefix'=>'admin','middleware' => ['auth:api'],'namespace'=>'Api\Admin'],function () {
            Route::group(['middleware' => ['acl'],'is' => 'administrador|moderador', 'protect_alias'  => 'user'],function (){
                Route::resource('contas-a-pagar', 'FinanceiroContaController',
                [
                    'except' => ['create', 'edit']
                ]);
            });
        });
    }
}