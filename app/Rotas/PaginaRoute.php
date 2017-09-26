<?php
/**
 * Created by PhpStorm.
 * User: dsoft
 * Date: 06/02/2017
 * Time: 16:29
 */

namespace Portal\Rotas;


use Portal\Interfaces\ICustomRoute;
use \Route;

class PaginaRoute implements ICustomRoute
{

    public static function run()
    {
        Route::group(['prefix'=>'admin','middleware' => ['auth:api'],'namespace'=>'Api\Admin'],function (){
            Route::group(['middleware' => ['acl'],'is' => 'administrador', 'protect_alias'  => 'user'],function (){
                Route::resource('pagina', 'PaginaController',[
                    'except' => ['create', 'edit']
                ]);
            });
        });
        Route::group(['prefix'=>'front','middleware' => ['auth:api','acl'],'is' => 'anunciante|administrador,or','namespace'=>'Api\Front'],function (){
            Route::get('pagina/conteudo/{slug}', 'PaginaController@showSlug');
        });
    }
}