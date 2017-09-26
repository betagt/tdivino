<?php
/**
 * Created by PhpStorm.
 * User: dsoft
 * Date: 06/02/2017
 * Time: 16:12
 */

namespace Modules\Plano\Rotas;


use Portal\Interfaces\ICustomRoute;
use \Route;

class FormaPagamentoRoute implements ICustomRoute
{

    public static function run()
    {
        Route::group(['prefix'=>'admin','middleware' => ['auth:api'],'namespace'=>'Api\Admin'],function (){
            Route::get('forma_pagamento/ativas', [
                'as' => 'user.api_forma_pagamento',
                'uses' => 'FormaPgtoController@formPgtoAtiva',
            ]);
            Route::get('forma_pagamento/pagseguro/session', [
                'as' => 'user.api_forma_pagamento_pagseguro_session',
                'uses' => 'FormaPgtoController@getSessionId',
            ]);
            Route::post('forma_pagamento/pagseguro/pagamento', [
                'as' => 'user.api_forma_pagamento_pagseguro_session',
                'uses' => 'FormaPgtoController@pagamento',
            ]);
            Route::group(['middleware'=>['acl'],'is'=>'administrador','protect_alias'=>'user'],function (){
                Route::resource('forma_pagamento', 'FormaPgtoController',
                    [
                        'except' => ['create', 'edit']
                    ]);
            });
         });
    }
}