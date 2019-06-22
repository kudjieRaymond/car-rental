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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/



//Grouping all the APIs routes
Route::group(['middleware' => 'cors','prefix' => '/v1'], function () {

	Route::post('register', 'AuthController@register');
	Route::post('login', 'AuthController@login');
	Route::post('logout/', 'AuthController@logout');   


	Route::group(['middleware' =>['auth:api']], function () { 
		Route::post('cars/save', 'CarController@store');
		Route::get('cars/', 'CarController@index');
		Route::get('cars/{car}', 'CarController@show');
		Route::post('cars/{car}/update', 'CarController@update');

		Route::post('car_types/save', 'CarTypeController@store');
		Route::get('car_types/', 'CarTypeController@index');
		Route::get('car_types/{car_type}', 'CarTypeController@show');
		Route::post('car_types/{car_type}/update', 'CarTypeController@update');

		Route::post('rentals/save', 'RentalController@store');
		Route::get('rentals/{rental}', 'RentalController@show');
		Route::post('rentals/{rental}/update/all', 'RentalController@update');
		Route::post('rentals/{rental}/update/{car}', 'RentalController@update_individual_car');

		Route::get('users/', 'UserController@index');
		Route::post('users/save', 'UserController@store');
		Route::post('users/{user}/update', 'UserController@update');
		Route::get('users/{user}', 'UserController@show');


	});
	 

});
