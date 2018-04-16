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

Route::post('login','Auth\LoginController@login');
Route::post('register','Auth\LoginController@register');
Route::get('logout','Auth\LoginController@logout');

//Route::group(['middleware'=>'auth'], function () {

    Route::prefix('user')->group(function () {
        Route::post('store','UserController@store');
        Route::get('/', 'UserController@show');
        Route::get('{user}', 'UserController@show');
    });

    Route::prefix('survey')->group( function () {
        Route::get('/','SurveyController@index');
        Route::post('/','SurveyController@store');

        Route::prefix('{survey}')->group(function(){
            Route::get('/','SurveyController@show');
            Route::get('edit','SurveyController@edit');
            Route::post('update','SurveyController@update');
            Route::delete('/','SurveyController@destroy');

            Route::prefix('questions')->group(function () {
                Route::get('/','QuestionController@index');
                Route::post('/','QuestionController@store');
                Route::get('{question}','QuestionController@show');
                Route::post('{question}','QuestionController@update');

                Route::prefix('{question}/options')->group( function () {
                    Route::get('/','AnswerOptionController@index');
                    Route::post('/','AnswerOptionController@store');
                    Route::get('{option}','AnswerOptionController@show');
                    Route::post('{option}','AnswerOptionController@update');
                    Route::delete('/','AnswerOptionController@destroy');
                });
            });
        });
    });

//});