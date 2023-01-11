<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Site\ToursController;

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

Route::group(['prefix' => 'auth', 'namespace' => 'Api\Auth'], function ($api) {
    $api->post('check-email', 'RegisterController@checkEmail');
    $api->post('check-unique-email', 'RegisterController@checkUniqueEmail');
});

Route::group(['middleware' => ['currency_mid', 'localizeApiRequests'], 'prefix' => 'filter', 'namespace' => 'Api'], function ($api) {
    $api->get('get-excursions-params', 'FilterController@getExcursionsParams');
    $api->get('excursions', 'FilterController@getExcursions');

    $api->get('get-tours-params', 'FilterController@getToursParams');
    $api->get('tours', 'FilterController@getTours');
});



Route::get('accommodations', [ToursController::class, 'accommodations'])->name('api.accommodations');
