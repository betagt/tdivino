<?php

Route::group(['middleware' => 'web', 'prefix' => 'geoposition', 'namespace' => 'Modules\GeoPosition\Http\Controllers'], function()
{
    Route::get('/', 'GeoPositionController@index');
});
