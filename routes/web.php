<?php

use Illuminate\Support\Facades\Route;
use App\SponsorshipType;
use App\Sponsorship;
use App\Apartment;
use App\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;

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

Route::get('/', 'HomeController@index');
// Route::get('/advancedsearch', 'Guest\ApartmentController');

Route::get('/search', 'HomeController@search')->name('search');
Route::get('/apartments/{slug}', 'Guest\ApartmentController@show')->name('guest.apartments.show');
Route::get('/apartments/{slug}/message', 'Guest\ApartmentController@message')->name('guest.apartments.message');
Route::post('/apartments/{slug}/message', 'Guest\ApartmentController@sendMessage')->name('guest.apartments.sendMessage');

Auth::routes();

Route::middleware('auth')->prefix('admin')->namespace('Admin')->name('admin.')->group(function() {
    Route::get('/', 'HomeController@index')->name('index');
    Route::resource('/apartments', 'ApartmentController');

    Route::get('/messages/{apartment_id}', 'MessageController@index')->name('messages.index');
    Route::get('/messages/{id}', 'MessageController@show')->name('messages.show');


    // *********** Pagamenti ***********
    Route::get('/apartments/{id}/sponsorship', 'PaymentController@pay')->name('apartments.sponsorship');
    Route::post('/checkout/{apartment_id}', 'PaymentController@checkout')->name('checkout');
});
