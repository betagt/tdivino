<?php

Route::group(['prefix'=>'v1','middleware' => ['cors']], function () {
    \Modules\Transporte\Rotas\ServicoRoute::run();
    \Modules\Transporte\Rotas\TipoDocumentoRoute::run();
    \Modules\Transporte\Rotas\DocumentoRoute::run();
    \Modules\Transporte\Rotas\VeiculoRoute::run();
    \Modules\Transporte\Rotas\MarcaCarroRoute::run();
    \Modules\Transporte\Rotas\ModeloCarroRoute::run();
    \Modules\Transporte\Rotas\ChamadaRoute::run();
    \Modules\Transporte\Rotas\ContaRoute::run();
    \Modules\Transporte\Rotas\BancoRoute::run();
});