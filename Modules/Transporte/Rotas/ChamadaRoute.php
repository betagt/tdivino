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
                Route::post('chamda/iniciar-chamada', [
                    'as' => 'chamda.iniciar-chamada',
                    'uses' => 'ChamadaController@iniciarChamada'
                ]);
            });
            Route::group(['middleware' => ['acl'],'is' => 'administrador|fornecedor', 'protect_alias'  => 'user'],function (){});
            Route::group(['middleware' => ['acl'],'is' => 'administrador|moderador,or', 'protect_alias'  => 'user'],function (){
                Route::resource('veiculo', 'VeiculoController',
                    [
                        'except' => ['create', 'edit']
                    ]);
            });
        });
    }
}