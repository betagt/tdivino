<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {

    \Cookie::queue(cookie('user_1_anuncio_18', 'teste', 1));
    /*$query = http_build_query([
        'client_id'=>3,
        'redirect_id'=>'http://localhost:9999/callback',
        'response_type'=>'code',
        'scope'=>''
    ]);

    return redirect('http://localhost:8000/oauth/authorize?'.$query);*/
});

Route::get('callback',function (\Illuminate\Http\Request $request){
   /* $code = $request->get('code');
    $http = new \GuzzleHttp\Client();
   $response = $http->post('http://localhost:8000/oauth/token',[
        'form_params'=>[
            'client_id'=>3,
            'client_secret'=>'ZVcaAEGympIVjgMArcNtM08GvRNzrXwXubIQI4u6',
            'redirect_id'=>'http://localhost:9999/callback',
            'code'=>$code,
            'grant_type'=>'authorization_code'
        ]
    ]);

    dd(json_decode($response->getBody(),true));*/
});

//Auth::routes();

Route::get('/home', 'HomeController@index');

