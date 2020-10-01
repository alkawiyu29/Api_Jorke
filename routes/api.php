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

Route::post('/register', 'Api\AuthController@register');
Route::post('/password/email', 'Api\ForgotPasswordController@kirimEmail');
Route::post('/password/reset', 'Api\ResetPasswordController@resetPassword');

Route::post('/login', 'Api\AuthController@login');

Route::group(['middleware' => 'verifyApiToken'], function () {

    //book
    Route::get('/books', 'Api\BookController@get');
    Route::post('/book', 'Api\BookController@post');
    Route::put('/book/{id}', 'Api\BookController@put');
    Route::delete('/book/{id}', 'Api\BookController@delete');

    //rack
    Route::get('/racks', 'Api\RackController@get');
    Route::post('/rack', 'Api\RackController@post');
    Route::put('/rack/{id}', 'Api\RackController@put');
    Route::delete('/rack/{id}', 'Api\RackController@delete');

    //categories
    Route::get('/categories', 'Api\CategoriesController@get');
    Route::post('/categorie', 'Api\CategoriesController@post');
    Route::put('/categorie/{id}', 'Api\CategoriesController@put');
    Route::delete('/categorie/{id}', 'Api\CategoriesController@delete');
});