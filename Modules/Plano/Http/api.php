<?php

Route::group(['prefix'=>'v1','middleware' => ['cors']], function () {
    \Modules\Plano\Rotas\PlanoRoute::run();
    \Modules\Plano\Rotas\FormaPagamentoRoute::run();
    \Modules\Plano\Rotas\PlanoContratacaoRoute::run();
});