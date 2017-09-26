<?php
/**
 * Created by PhpStorm.
 * User: dsoft
 * Date: 06/02/2017
 * Time: 16:08
 */

namespace Modules\Localidade\Rotas;

use Portal\Interfaces\ICustomRoute,
    \Route;

class LocalidadeRoute implements ICustomRoute
{

    public static function run()
    {
        Route::group(['prefix'=>'admin','middleware' => ['auth:api'],'namespace'=>'Api\Admin'],function (){
            Route::get('localidade/cidades/select-cidades/{estadoId}', [
                'as' => 'plano.consulta_cidades',
                'uses' => 'LocalidadeController@selectCidades'
            ]);
            Route::get('localidade/bairro/select-bairros/{cidadeId}', [
                'as' => 'plano.consulta_bairros',
                'uses' => 'LocalidadeController@selectBairros'
            ]);
            Route::get('localidade/geo-localizacao/{cidade}/{endereco}/{estado}', [
                'as' => 'plano.consulta_geo_localizacao',
                'uses' => 'LocalidadeController@getSinglePosition'
            ]);
            Route::get('localidade/estados/select-estados', [
                'as' => 'plano.consulta_estaos',
                'uses' => 'LocalidadeController@selectEstados'
            ]);
            Route::group(['middleware' => ['acl'],'is' => 'administrador', 'protect_alias'  => 'user'],function (){

            });
        });
        Route::group(['prefix'=>'front','namespace'=>'Api\Front'],function (){
            Route::get('localidade/cidades/select-cidades/{estadoId}', [
                'as' => 'plano.consulta_cidades',
                'uses' => 'LocalidadeController@selectCidades'
            ]);
            Route::get('localidade/bairro/select-bairros/{cidadeId}', [
                'as' => 'plano.consulta_bairros',
                'uses' => 'LocalidadeController@selectBairros'
            ]);
            Route::get('localidade/estados/select-estados', [
                'as' => 'plano.consulta_estaos',
                'uses' => 'LocalidadeController@selectEstados'
            ]);
            Route::get('localidade/cep-localidade/{cep}', [
                'as' => 'plano.consulta_estaos',
                'uses' => 'LocalidadeController@localidadeByCep'
            ]);
            Route::get('localidade/filter-localidade', [
                'as' => 'plano.consulta_estaos',
                'uses' => 'LocalidadeController@filterLocalidade'
            ]);
        });
    }
}