<?php

namespace Modules\Plano\Rotas;
use Portal\Interfaces\ICustomRoute;
use \Route;

class PlanoContratacaoRoute implements ICustomRoute
{

    public static function run()
    {
        Route::group(['prefix'=>'admin','middleware' => ['auth:api'],'namespace'=>"Api\Admin"],function (){
            Route::group(['middleware'=>['acl'],'is'=>'administrador','protect_alias'=>'user'],function (){
                Route::post('plano_contratacao/envia-email-contratacao', [
                    'as' => 'plano_contratacao.envia_email_contratacao',
                    'uses' => 'PlanoContratacaoController@enviarEmailContratacao'
                ]);
                Route::get('plano_contratacao/lancamentos/{contratacao}', [
                    'as' => 'plano_contratacao.lancamentos',
                    'uses' => 'PlanoContratacaoController@indexLancamento'
                ]);
                Route::resource("plano_contratacao", "PlanoContratacaoController",[
                    'except' => ['create', 'edit']
                ]);
            });
        });
        Route::group(['prefix'=>'front','middleware' => ['auth:api'],'namespace'=>"Api\Front"],function (){
            Route::group(['middleware'=>['acl'],'is'=>'administrador|anunciante|moderator|qative','protect_alias'=>'user'],function (){
                Route::post('plano_contratacao', [
                    'as' => 'plano_contratacao.plano_contratacao',
                    'uses' => 'PlanoContratacaoController@contratacao'
                ]);
                Route::get('plano_contratacao/{id}', [
                    'as' => 'plano_contratacao.plano_contratacao',
                    'uses' => 'PlanoContratacaoController@show'
                ]);
                Route::put('plano_contratacao/{id}', [
                    'as' => 'plano_contratacao.plano_contratacao',
                    'uses' => 'PlanoContratacaoController@update'
                ]);
            });
        });
    }
}