<?php

Route::group(['middleware' => 'web', 'prefix' => 'transporte', 'namespace' => 'Modules\Transporte\Http\Controllers'], function()
{
    Route::get('/', 'TransporteController@index');
});
