<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', 'RegisterController@register');

Route::group(['prefix' => 'hangers'], function () {
    Route::get('/', 'HangerController@index')->middleware('auth:api');
    Route::get('/{hanger}', 'HangerController@show')->middleware('auth:api');;
    Route::post('/', 'HangerController@store')->middleware('auth:api');
    Route::patch('/{hanger}', 'HangerController@update')->middleware('auth:api');;
    Route::delete('/{hanger}', 'HangerController@destroy')->middleware('auth:api');;

    Route::group(['prefix' => '/{hanger}/photos'], function () {
        Route::post('/', 'PhotoController@store')->middleware('auth:api');;
        Route::patch('/{photo}', 'PhotoController@update')->middleware('auth:api');;
        Route::delete('/{photo}', 'PhotoController@destroy')->middleware('auth:api');;
    });
});
