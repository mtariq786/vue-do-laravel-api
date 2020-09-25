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


Route::group(['middleware'=> 'auth:api'], function (){
    Route::get('/user', function (Request $request) {
        return $request->user();
    });


    Route::get('/todos','TodoController@index');
    Route::post('/todos','TodoController@store');
    Route::patch('/todos/{todo}','TodoController@update');
    Route::delete('/todos/{todo}','TodoController@destroy');
    Route::patch('/todos-check-all','TodoController@checkAll');
    Route::post('/todosDeleteAll','TodoController@DeleteAll');

    Route::post('logout','AuthController@logout');
});

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/


Route::post('login','AuthController@login');

Route::post('register','AuthController@register');

