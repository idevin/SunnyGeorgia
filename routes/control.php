<?php
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'control', 'as' => 'control:', 'namespace' => 'Control', 'middleware' => ['role:admin|seo|staff', 'auth']], function () {

    Route::group(['prefix' => 'users', 'as' => 'users.', 'middleware' => ['permission:users-*']], function () {

        Route::get('/', 'UsersController@index')->name('index');
        Route::get('{user}', 'UsersController@view')->name('view');
        Route::get('{user}/admin_toggle', 'UsersController@userAdmin')->name('admin_toggle');
        Route::post('{user}', 'UsersController@update')->name('update');
        Route::get('{user}/bookings', 'UsersController@bookings')->name('bookings');
    });

    Route::group(['prefix' => 'tours', 'as' => 'tours.', 'middleware' => ['permission:tours-*']], function () {
        Route::get('booking', 'ToursBookingController@index')->name('booking.index');

        Route::get('booking/{id}', 'ToursBookingController@view')->name('booking.view');
        Route::post('booking/{id}', 'ToursBookingController@update')->name('booking.update');

        Route::get('/', 'ToursController@index')->name('index');
        Route::get('{id}', 'ToursController@edit')->name('edit');
        Route::post('{id}', 'ToursController@update')->name('update');
        Route::post('moderator-data/{id}', 'ToursController@updateModeratorData')->name('update-moderator-data');
        Route::delete('{id}', 'ToursController@delete')->name('delete');

        Route::get('{id}/calendar', 'ToursController@calendar')->name('calendar');
        Route::get('{id}/accommodations', 'ToursController@accommodation')->name('accommodation');
        Route::post('{id}/accommodations', 'ToursController@postAccommodation')->name('accommodation.post');

        Route::post('{id}/accommodations_update', 'ToursController@updateAccommodation')->name('accommodation.update');

        Route::post('accommodations/availability_form', 'ToursController@postAccommodationAvailabilityForm')->name('accommodation.update_availability_form');
        Route::post('{id}/accommodations/availability_modal', 'ToursController@postAccommodationAvailabilityModal')->name('accommodation.update_availability');
        Route::get('{id}/accommodations/{ac_id}/delete', 'ToursController@deleteAccommodation')->name('accommodation.delete');

        Route::get('{id}/reviews', 'ReviewsController@reviews')->name('reviews');
        Route::get('{id}/reviews/new', 'ReviewsController@newReview')->name('new-review');
        Route::get('{id}/reviews/{reviewId}', 'ReviewsController@getReview')->name('get-review');
        Route::post('{id}/reviews/{reviewId}', 'ReviewsController@updateReview')->name('update-review');
        Route::get('{id}/reviews/{reviewId}/toggle', 'ReviewsController@toggleReview')->name('toggle-review');
        Route::post('{id}/generate-review', 'ReviewsController@generateReview')->name('generate-review');
    });

    Route::group(['prefix' => 'excursions', 'as' => 'excursions.', 'middleware' => ['permission:excursions-*']], function () {
        Route::get('booking', 'ExcursionsBookingController@index')->name('booking.index');
        Route::get('booking/{id}', 'ExcursionsBookingController@view')->name('booking.view');
        Route::post('booking/{id}', 'ExcursionsBookingController@update')->name('booking.update');

        Route::get('/', 'ExcursionsController@index')->name('index');
//        Route::get('create', 'ExcursionsController@create')->name('create');
//        Route::post('create', 'ExcursionsController@store')->name('store');
        Route::get('{id}', 'ExcursionsController@edit')->name('edit');
        Route::post('{id}', 'ExcursionsController@update')->name('update');
        Route::post('moderator-data/{id}', 'ExcursionsController@updateModeratorData')->name('update-moderator-data');
        Route::delete('{id}', 'ExcursionsController@delete')->name('delete');

        Route::post('{id}/availability', 'ExcursionsController@postAvailability')->name('availability.update');
        Route::get('{id}/availability/delete', 'ExcursionsController@deleteAvailabilities')->name('availabilities.delete');
        Route::post('{id}/availability_form', 'ExcursionsController@postAvailabilityForm')->name('availability.update_form');
//            Route::delete('{id}/media/{media_id}', 'ToursController@mediaDelete')->name('media.delete');
        Route::get('{id}/calendar', 'ExcursionsController@calendar')->name('calendar');

        Route::get('{id}/reviews', 'ReviewsController@reviews')->name('reviews');
        Route::get('{id}/reviews/new', 'ReviewsController@newReview')->name('new-review');
        Route::get('{id}/reviews/{reviewId}', 'ReviewsController@getReview')->name('get-review');
        Route::get('{id}/reviews/{reviewId}/toggle', 'ReviewsController@toggleReview')->name('toggle-review');
        Route::post('{id}/reviews/{reviewId}', 'ReviewsController@updateReview')->name('update-review');
        Route::post('{id}/generate-review', 'ReviewsController@generateReview')->name('generate-review');
    });

    Route::group(['prefix' => 'options', 'as' => 'options.', 'middleware' => ['permission:settings-options-*']], function () {
        Route::get('/', 'OptionsController@index')->name('index');
        Route::get('create', 'OptionsController@create')->name('create');
        Route::post('create', 'OptionsController@store')->name('store');
        Route::get('{id}', 'OptionsController@edit')->name('edit');
        Route::post('{id}', 'OptionsController@update')->name('update');
        Route::get('option/{id}/delete', 'OptionsController@optionDelete')->name('option.delete');
        Route::get('group/{id}/delete', 'OptionsController@groupDelete')->name('group.delete');
    });

    Route::group(['as' => 'places.', 'middleware' => ['permission:settings-places-*']], function () {
        Route::get('places', 'PlacesController@index')->name('index');
        Route::get('places/{id}', 'PlacesController@view')->name('view');
        Route::post('places/{id}', 'PlacesController@update')->name('update');
    });

    Route::get('payments', ['uses' => 'PaymentsController@index', 'middleware' => ['permission:billing-payments-view']])->name('payments.index');

    Route::group(['prefix' => 'billing', 'as' => 'billing.', 'middleware' => ['permission:billing-index-*']], function () {
        Route::get('/', 'BillingController@index')->name('index');
        Route::get('export', 'BillingController@export')->name('export');
    });

    Route::post('media/uploader', 'MediaController@uploader')->name('media.uploader');
    Route::delete('media/{id}', 'MediaController@delete')->name('media.delete');
    Route::get('permissions', ['uses' => 'PermissionsController@index', 'middleware' => 'role:admin'])->name('permission.index');
    Route::post('permissions', ['uses' => 'PermissionsController@syncRoles', 'middleware' => 'role:admin'])->name('permission.index');


    Route::resource('pages', 'PagesController');
});
