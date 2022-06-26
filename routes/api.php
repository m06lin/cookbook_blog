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
Route::post('login', 'AuthUserController@login');

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'AuthUserController@logout');
    Route::get('profile', 'AuthUserController@userProfile');

    Route::get('recipe', 'RecipeController@query');

    Route::get('dish_type/{id?}', 'DishTypeController@list');
    Route::post('dish_type', 'DishTypeController@create');
    Route::put('dish_type/{id}', 'DishTypeController@update');
    Route::delete('dish_type/{id}', 'DishTypeController@delete');
});