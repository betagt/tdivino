<?php
    namespace Modules\Core\Rotas;
    use Portal\Interfaces\ICustomRoute;
    use \Route;
/**
 * Created by PhpStorm.
 * User: dsoft
 * Date: 06/02/2017
 * Time: 15:22
 */
class UserRoute implements ICustomRoute
{
    public static function run()
    {
        Route::post('admin/user/faleconosco', [
            'as' => 'user.solicitar_nova_senha',
            'uses' => 'Api\Front\UserController@faleConosco'
        ]);
        Route::post('admin/user/password/reset', [
            'as' => 'user.solicitar_nova_senha',
            'uses' => 'Api\Admin\UserController@solicitarNovaSenha'
        ]);
        Route::post('front/user/registrar', [
            'as' => 'user.registrar',
            'uses' => 'Api\Front\UserController@cadastrar'
        ]);
        Route::post('admin/user/registrar', [
            'as' => 'user.registrar',
            'uses' => 'Api\Admin\UserController@cadastrar'
        ]);
        Route::post('front/user/password/reset/change', [
            'as' => 'user.criar_nova_senha',
            'uses' => 'Api\Front\UserController@criarNovaSenha',
        ]);
        Route::post('front/user/password/reset', [
            'as' => 'user.solicitar_nova_senha',
            'uses' => 'Api\Front\UserController@solicitarNovaSenha'
        ]);
		Route::group(['prefix'=>'admin', 'middleware'=>['auth:api','acl'],'is'=>'administrador|agencia-reguladora|moderator','protect_alias'=>'user','namespace'=>'Api\Admin'], function (){
			Route::get('user/lista-fornecedores', [
				'as' => 'user.select-list',
				'uses' => 'UserController@listagemFornecedores',
			]);
		});

        Route::group(['prefix'=>'admin','middleware' => ['auth:api','acl'],'is' => 'administrador|agencia-reguladora|fornecedor|taxista|mototaxista|cliente|moderator','namespace'=>'Api\Admin'],function (){
            Route::post('user/device_register', [
                'as' => 'user.device_register',
                'uses' => 'UserController@deviceRegister',
            ]);
			Route::get('user/perfil/', [
				'as' => 'user.meu_perfil',
				'uses' => 'UserController@myProfile'
			]);
			Route::post('user/posicao', [
				'as' => 'user.posicao',
				'uses' => 'UserController@userPosicao'
			]);
            Route::get('user/logout', [
                'as' => 'user.meu_perfil',
                'uses' => 'UserController@logout'
            ]);
            Route::get('user/vizualizar-fornecedor/{id}', [
                'as' => 'user.select-list',
                'uses' => 'UserController@vizualizarFornecedor',
            ])->where('id', '[0-9\s+]+');

            Route::post('user/cliente-cadastrar', [
                'as' => 'user.posicao',
                'uses' => 'UserController@storeCliente'
            ]);
            Route::put('user/cliente-update/{id}', [
                'as' => 'user.posicao',
                'uses' => 'UserController@updateCliente'
            ]);
        });

        Route::group(['prefix'=>'admin','middleware' => ['auth:api'],'namespace'=>'Api\Admin'],function (){
            Route::get('user/perfil/', [
                'as' => 'user.meu_perfil',
                'uses' => 'UserController@myProfile'
            ]);
            Route::post('user/password/change', [
                'as' => 'user.alterar_senha',
                'uses' => 'UserController@alterarSenha',
            ]);
            Route::group(['middleware'=>['acl'],'is' => 'administrador|fornecedor|taxista|mototaxista|moderator','protect_alias'=>'user'],function (){
                Route::post('user/alterar_imagem', [
                    'as' => 'user.alterar_imagem',
                    'uses' => 'UserController@changeImage',
                ]);
                Route::put('user/userupdate', [
                    'as' => 'user.alterar_senha',
                    'uses' => 'UserController@updateCurrentUser',
                ]);
				Route::get('user/operacao', [
					'as' => 'user.operacao',
					'uses' => 'UserController@onlineOffline',
				]);
                Route::put('user/update-user-pessoa', [
                    'as' => 'user.alterar_senha',
                    'uses' => 'UserController@updatePessoa',
                ]);
            });
            //Route::group(['middleware' => ['acl'],'is' => 'administrador', 'protect_alias'  => 'user'],function (){
            Route::group(['middleware'=>['acl'],'is'=>'administrador','protect_alias'=>'user'],function (){
               /* Route::post('user/password/reset', [
                    'as' => 'user.solicitar_nova_senha',
                    'uses' => 'UserController@solicitarNovaSenha'
                ]);*/
                Route::get('user/select-list/{like}', [
                    'as' => 'user.select-list',
                    'uses' => 'UserController@selectList',
                ])->where('like', '[A-Za-z0-9\s+]+');
                Route::post('user/password/reset/change', [
                    'as' => 'user.criar_nova_senha',
                    'uses' => 'UserController@criarNovaSenha',
                ]);
                Route::post('user/alterar_imagem_admin/{id}', [
                    'as' => 'user.alterar_imagem',
                    'uses' => 'UserController@changeImageAdmin',
                ]);

                Route::resource('user', 'UserController',[
                    'except' => ['create', 'edit']
                ]);
            });
        });
        Route::group(['prefix'=>'front','middleware' => ['auth:api','acl'],'is' => 'administrador|cliente|moderator','namespace'=>'Api\Front'],function (){


            Route::put('user/userupdate', [
                'as' => 'user.alterar_senha',
                'uses' => 'UserController@updateCurrentUser',
            ]);

            Route::post('user/alterar_imagem', [
                'as' => 'user.alterar_imagem',
                'uses' => 'UserController@changeImage',
            ]);

            Route::put('user/password/change', [
                'as' => 'user.alterar_senha',
                'uses' => 'UserController@alterarSenha',
            ]);

        });
    }
}