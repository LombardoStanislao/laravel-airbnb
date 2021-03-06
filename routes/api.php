<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

Route::get('/filteredSearch', 'Api\ApartmentController@filteredSearch');

Route::get('/showViews', 'Api\ApartmentController@showViews');

Route::get('/getApartment', 'Api\ApartmentController@getApartment');

Route::get('/isSponsored', 'Api\ApartmentController@isSponsored');

Route::post('/viewedMessage', 'Api\MessageController@viewedMessage');

Route::get('/clientToken', 'Api\PaymentController@clientToken');

Route::get('/getAllComforts', 'Api\ComfortController@getAllComforts');
