<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return config('app.name');
});

Route::group(['prefix' => 'view'], function () {
    Route::post('login', 'AuthUserController@login');

    Route::group(['middleware' => 'auth:web'], function () {
        Route::post('logout', 'AuthUserController@logout');

        Route::get('profile', 'AuthUserController@userProfile');
        Route::get('profile/receipts', 'AuthUserController@receiptList');

        Route::get('recipe', 'RecipeController@query');

        Route::get('dish-type/{id?}', 'DishTypeController@list');
        Route::post('dish-type', 'DishTypeController@create');
        Route::put('dish-type/{id}', 'DishTypeController@update');
        Route::delete('dish-type/{id}', 'DishTypeController@delete');
    });
});
