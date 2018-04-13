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

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::post('login', 'Auth\LoginController@login');

Route::prefix('user')->group(function () {
    Route::post('create', 'UserController@create');
    Route::get('update', 'UserController@update');
    Route::get('destroy', 'Usercontroller@delete');
    Route::get('{user}', 'UserController@show');
});
