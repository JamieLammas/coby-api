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
    Route::get('/', 'HangersController@index');
    Route::get('/{hanger}', 'HangersController@show');
    Route::post('/', 'HangersController@store');
    Route::patch('/{hanger}', 'HangersController@update');
    Route::delete('/{hanger}', 'HangersController@destroy');

    Route::group(['prefix' => '/{hanger}/photo'], function () {
        Route::post('/', 'PhotoController@store');
        Route::patch('/{photo}', 'PhotoController@update');
        Route::delete('/{photo}', 'PhotoController@destroy');
    });
});
