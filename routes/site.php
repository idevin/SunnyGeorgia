<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

//  Unsorted:
//  sitemap.xml
Route::get('sitemap.xml', 'Site\SitemapsController@index')->name('sitemap');
// 'home-1' redirect ???
Route::get('/', 'Site\MainController@root')->name('home-1');
// User activation link
Route::get('user/activation/{token}', 'Auth\ActivationController@activateUser')->name('user.activate');
// Change language link
Route::get('language/{locale}', 'Site\MainController@changeLanguage')->name('change_language');

// @TODO Should move to API routes
Route::get('xhr/weather', 'XHR\WeatherController@getWeather')->name('xhr.weather');
Route::get('xhr/user/email_check', ['uses' => 'XHR\UserController@checkEmail', 'middleware' => 'throttle', 'locale'])->name('xhr.user.email_check');

// Payment group   ====================================================
Route::group(['prefix' => 'payment'], function ($route) {
    Route::any('geo/success', ['uses' => 'Payment\GeoPayController@success', 'middleware' => 'cabinet_locale'])->name('geopay.success');
    Route::any('geo/fail', ['uses' => 'Payment\GeoPayController@fail', 'middleware' => 'cabinet_locale'])->name('geopay.fail');
    Route::any('geo/postback', 'Payment\GeoPayController@postBack');
});

// Socialite group ====================================================
Route::group(['prefix' => 'login'], function ($route) {
    // Facebook endpoint
    Route::get('facebook', 'Auth\FacebookLoginController@redirectToProvider')->name('socialite.facebook.redirect');
    Route::get('facebook/callback', 'Auth\FacebookLoginController@handleProviderCallback')->name('socialite.facebook.callback');

    // Google endpoint
    Route::get('google', 'Auth\GoogleLoginController@redirectToProvider')->name('socialite.google.redirect');
    Route::get('google/callback', 'Auth\GoogleLoginController@handleProviderCallback')->name('socialite.google.callback');
});

// Locale group    ====================================================
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['geo', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'currency_mid']
], function ($route) {
    Auth::routes();

    // Home page
    Route::get('/', 'Site\MainController@pages')->name('main');

    // Translations for js | OLD  @TODO remove !!!
    Route::get('ljs/lang.txt', 'Site\TranslationsController@jsLangs')->name('i18n-js');

    // Soft registration
    Route::post('register-soft', ['uses' => 'Auth\RegisterController@softRegistration', 'middleware' => 'guest'])->name('register.soft');

    // Static pages
    Route::get('terms', 'Site\MainController@pages')->name('terms');
    Route::get('rules', 'Site\MainController@pages')->name('rules');

    Route::get('legal-information', 'Site\MainController@pages')->name('legal-information');

    Route::get('contacts', 'Site\MainController@pages')->name('contacts');
    Route::get('qa', 'Site\MainController@pages')->name('qa');
    Route::get('about', 'Site\MainController@pages')->name('about');
    Route::get('be-partner', 'Site\MainController@pages')->name('be-partner');
    Route::post('contacts', 'Site\MainController@postContacts')->name('contacts');

    // Tours
    Route::get('tours', 'Site\ToursController@index')->name('tours.index');
    Route::get('tours/{tour}', 'Site\ToursController@view')->name('tours.view');
    Route::post('tours', 'Site\TourBookingController@postBooking')->name('tours.request');

    // Excursions
    Route::get('excursions', 'Site\ExcursionsController@index')->name('excursions.index');
    Route::get('excursions/{excursion}', 'Site\ExcursionsController@view')->name('excursions.view');
    Route::post('excursions_booking', 'Site\ExcursionBookingController@postBooking')->name('excursions.request');
//    Route::post('excursions', 'Site\ExcursionBookingController@postBooking')->name('excursions.request');
    Route::get('excursion_booking/{id}/checkout', 'Site\ExcursionBookingController@checkout1')
        ->name('excursions.checkout1');

    // Checkout page ====================================================
    Route::group(['middleware' => 'auth'], function ($route) {
        // Tours Checkout page
        Route::get('tour_booking/{id}/checkout', 'Site\TourBookingController@checkout1')->name('tours.checkout1');
        Route::get('tour_booking/{id}/checkout2', 'Site\TourBookingController@checkout2')->name('tours.checkout2');
        Route::post('tour_booking/{tourBooking}/postCheckout', 'Site\TourBookingController@postForPay')->name('tours.checkout1_post');

        // Excursion Checkout page
        Route::get('excursion_booking/{id}/checkout2', 'Site\ExcursionBookingController@checkout2')->name('excursions.checkout2');
        Route::post('excursion_booking/{tourBooking}/postCheckout', 'Site\ExcursionBookingController@postForPay')->name('excursions.checkout1_post');
    });

    Route::group(['middleware' => 'auth', 'prefix' => 'sms', 'namespace' => 'Cabinet'], function ($route) {
        Route::get('confirm-send', 'ProfileController@sendMobileCode');
        Route::get('confirm-resend', 'ProfileController@resendMobileCode');
        Route::get('confirm-check', 'ProfileController@xhrConfirmMobileCode');
    });

    // Places
    $places = \App\Place::all();
    foreach ($places as $place) {
        Route::get($place->slug, 'Site\PlaceController@view')->name($place->slug);

        // redirect old routes
        Route::permanentRedirect($place->slug . '/excursions', '/' . LaravelLocalization::setLocale() . '/excursions?place=' . $place->id)
            ->name('redirect-place-tour');
        Route::permanentRedirect($place->slug . '/tours', '/' . LaravelLocalization::setLocale() . '/tours?place=' . $place->id)
            ->name('redirect-place-tour');
    }
});
