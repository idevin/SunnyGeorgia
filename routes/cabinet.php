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

Route::post('cabinet/logout', 'Auth\LoginController@logout')->name('cabinet-logout');
Route::group(['prefix' => 'cabinet', 'as' => 'cabinet:', 'namespace' => 'Cabinet', 'middleware' => ['role:user|partner', 'auth', 'currency_mid']], function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');

    Route::get('resend-activation-link', 'ProfileController@resendEmailLink')->name('profile.activate_email_link');

    Route::get('profile', 'ProfileController@index')->name('profile.view');
    Route::post('profile', 'ProfileController@update')->name('profile.update');
    Route::post('profile-public', 'ProfileController@updatePublicData')->name('profile.update_public');
    Route::post('change-password', 'ProfileController@passwordChange')->name('profile.change_password');

    Route::get('confirm-send', 'ProfileController@resendMobileCode')->name('profile.mobile.send_sms');
    Route::get('confirm-check', 'ProfileController@xhrConfirmMobileCode')->name('profile.mobile.confirm');

    Route::get('become-partner', 'ProfileController@becomePartner')->name('profile.become_partner');
    Route::post('become-partner', 'ProfileController@postBecomePartner')->name('profile.become_partner');

    Route::view('offers/tours/ru', 'cabinet.offers.ru_offer_tours')->name('offers.tours.ru');
    Route::view('offers/tours/ka', 'cabinet.offers.ka_offer_tours')->name('offers.tours.ka');

    Route::get('orders', 'OrdersController@index')->name('orders.index');
    Route::get('orders/tour/{id}', 'OrdersController@tourBookingView')->name('orders.tour_view');
    Route::get('orders/tour/{id}/cancel', 'OrdersController@tourBookingCancel')->name('orders.tour_cancel');
    Route::get('orders/excursion/{id}', 'OrdersController@excursionBookingView')->name('orders.excursion_view');
    Route::get('orders/excursion/{id}/cancel', 'OrdersController@excursionBookingCancel')->name('orders.excursion_cancel');

    Route::post('review/excursion/{id}', 'OrdersController@excursionReview')->name('review.excursion');
    Route::post('review/tour/{id}', 'OrdersController@tourReview')->name('review.tour');

//    Route::group(['prefix' => 'user', 'as' => 'user:', 'namespace' => 'User', 'middleware' => ['role:user']], function () {
//        Route::get('bookings', 'BookingsController@index')->name('bookings.index');
//    });

    Route::group(['prefix' => 'partner', 'as' => 'partner:', 'namespace' => 'Partner', 'middleware' => ['role:partner']], function () {
        Route::get('profile', 'ProfileController@view')->name('profile.view');
        Route::post('profile', 'ProfileController@update')->name('profile.update');

        Route::get('billing', 'ProfileController@viewBilling')->name('billing.view');
        Route::post('billing', 'ProfileController@updateBilling')->name('billing.update');

        Route::get('property', 'HotelsController@index')->name('hotels.index');
        Route::get('property/create', 'HotelsController@create')->name('hotels.create');
        Route::post('property/create', 'HotelsController@store')->name('hotels.store');
        Route::get('property/{id}/edit', 'HotelsController@edit')->name('hotels.edit');
        Route::post('property/{id}/edit', 'HotelsController@update')->name('hotels.update');
        Route::group(['prefix' => 'tours', 'as' => 'tours.', 'middleware' => ['role:partner']], function () {
            Route::view('calendar', 'cabinet.partner.tours.calendar');
            Route::get('booking', 'ToursBookingController@index')->name('booking.index');
            Route::get('booking/{id}', 'ToursBookingController@view')->name('booking.view');
            Route::post('booking/{id}', 'ToursBookingController@update')->name('booking.update');

            Route::get('/', 'ToursController@index')->name('index');
            Route::get('create', 'ToursController@create')->name('create');
            Route::post('create', 'ToursController@store')->name('store');
//            Route::get('create/{id}/step2/', 'ToursController@create2')->name('create.step2');
//            Route::post('create/{id}/step2', 'ToursController@store2')->name('store.step2');
//            Route::get('create/{id}/step3', 'ToursController@create3')->name('create.step3');
//            Route::post('create/{id}/step3', 'ToursController@store3')->name('store.step3');
            Route::get('{id}', 'ToursController@edit')->name('edit');
            Route::post('{id}', 'ToursController@update')->name('update');
            Route::delete('{id}', 'ToursController@delete')->name('delete');
            Route::get('{id}/calendar', 'ToursController@calendar')->name('calendar');
            Route::delete('{id}/media/{media_id}', 'ToursController@mediaDelete')->name('media.delete');
            Route::get('{id}/accommodations', 'ToursController@accommodation')->name('accommodation');
            Route::post('{id}/accommodations', 'ToursController@postAccommodation')->name('accommodation.post');

            Route::post('{id}/accommodations_update', 'ToursController@updateAccommodation')->name('accommodation.update');

            Route::post('accommodations/availability_form', 'ToursController@postAccommodationAvailabilityForm')->name('accommodation.update_availability_form');
            Route::post('accommodations/availability_modal', 'ToursController@postAccommodationAvailabilityModal')->name('accommodation.update_availability');
            Route::get('{id}/accommodations/{ac_id}/delete', 'ToursController@deleteAccommodation')->name('accommodation.delete');
        });

        Route::group(['prefix' => 'excursions', 'as' => 'excursions.', 'middleware' => ['role:partner']], function () {
//            Route::view('calendar', 'cabinet.partner.tours.calendar');
            Route::get('booking', 'ExcursionsBookingController@index')->name('booking.index');
            Route::get('booking/{id}', 'ExcursionsBookingController@view')->name('booking.view');
            Route::post('booking/{id}', 'ExcursionsBookingController@update')->name('booking.update');

            Route::get('/', 'ExcursionsController@index')->name('index');
            Route::get('create', 'ExcursionsController@create')->name('create');
            Route::post('create', 'ExcursionsController@store')->name('store');
            Route::get('{id}', 'ExcursionsController@edit')->name('edit');
            Route::post('{id}', 'ExcursionsController@update')->name('update');
            Route::delete('{id}', 'ExcursionsController@delete')->name('delete');
            Route::delete('{id}/media/{media_id}', 'ExcursionsController@mediaDelete')->name('media.delete');

            Route::post('{id}/availability', 'ExcursionsController@postAvailability')->name('availability.update');
            Route::get('{id}/availability/delete', 'ExcursionsController@deleteAvailabilities')->name('availabilities.delete');
            Route::post('{id}/availability_form', 'ExcursionsController@postAvailabilityForm')->name('availability.update_form');

//            Route::delete('{id}/media/{media_id}', 'ToursController@mediaDelete')->name('media.delete');
            Route::get('{id}/calendar', 'ExcursionsController@calendar')->name('calendar');
        });
    });
    Route::post('media/upload_file', 'MediaController@uploadFile')->name('media.upload_one');
    Route::post('media/upload_avatar', 'MediaController@uploadAvatar')->name('media.upload_avatar');
    Route::post('media/upload_logo', 'MediaController@uploadCompanyLogo')->name('media.upload_company_logo');
    Route::post('media/upload_files', 'MediaController@uploadMany')->name('media.upload_many');
    Route::post('media/uploader', 'MediaController@uploader')->name('media.uploader');

    Route::post('media/upload_tiny', 'MediaController@uploaderTiny');

    Route::delete('media/{id}', 'MediaController@delete')->name('media.delete');

    Route::post('bug', 'BugController@post')->name('bug');

});
