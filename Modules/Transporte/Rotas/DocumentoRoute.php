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

class DocumentoRoute implements ICustomRoute
{

    public static function run()
    {
        Route::group(['prefix'=>'admin','middleware' => ['auth:api'],'namespace'=>'Api\Admin'],function () {
            Route::group(['middleware' => ['acl'],'is' => 'administrador|fornecedor', 'protect_alias'  => 'user'],function (){
                Route::get('documento/meus-docuemntos', [
                    'as' => 'documento.meus_docuemntos',
                    'uses' => 'DocumentoController@meusdocumentos'
                ]);
                Route::post('documento/arquivo/{id}', [
                    'as' => 'user.alterar_imagem',
                    'uses' => 'DocumentoController@arquivo',
                ]);
                Route::post('documento/documento-user', [
                    'as' => 'user.alterar_imagem',
                    'uses' => 'DocumentoController@storeByUser',
                ]);
                Route::post('documento/arquivo-user/{id}', [
                    'as' => 'user.alterar_imagem',
                    'uses' => 'DocumentoController@arquivo',
                ]);
            });
            Route::group(['middleware' => ['acl'],'is' => 'administrador|moderador', 'protect_alias'  => 'user'],function (){
                Route::get('documento/aceitar/{id}', [
                    'as' => 'documento.aceitar',
                    'uses' => 'DocumentoController@aceitar'
                ]);
                Route::get('documento/recusar/{id}', [
                    'as' => 'documento.recusar',
                    'uses' => 'DocumentoController@recusar'
                ]);
                Route::post('documento/arquivo/{id}', [
                    'as' => 'user.alterar_imagem',
                    'uses' => 'DocumentoController@arquivo',
                ]);
                Route::resource('documento', 'DocumentoController',
                    [
                        'except' => ['create', 'edit']
                    ]);
            });
        });
    }
}