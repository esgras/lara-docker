<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group([
    'prefix' => 'posts',
    'namespace' => 'Api'
], function () {
    Route::get('/', 'PostController@findAll');
    Route::post('/', 'PostController@create');
    Route::get('/{id}', 'PostController@find');
    Route::put('/{id}', 'PostController@update');
    Route::delete('/{id}', 'PostController@delete');
});

Route::get('/health-check', function() {
    return new \Illuminate\Http\JsonResponse(['success' => true]);
});
