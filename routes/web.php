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

Route::get('/', 'HomeController@index');
// Route::get('/advancedsearch', 'Guest\ApartmentController');

Route::get('/search', 'HomeController@search')->name('search');
Route::get('/apartments/{slug}', 'Guest\ApartmentController@show')->name('guest.apartments.show');

Auth::routes();

Route::middleware('auth')->prefix('admin')->namespace('Admin')->name('admin.')->group(function() {
    Route::get('/', 'HomeController@index')->name('index');
    Route::get('/apartments/payments', 'ApartmentController@payments')->name('apartments.payments');
    Route::resource('/apartments', 'ApartmentController');
});
