<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Braintree\Gateway;
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

Route::post('/addView', 'Api\ApartmentController@addView');

Route::get('/showViews', 'Api\ApartmentController@showViews');

Route::post('/viewedMessage', 'Api\MessageController@viewedMessage');

Route::get('/clientToken', function() {
    $gateway = new Gateway([
        'environment' => 'sandbox',
        'merchantId' => 'n67d8y97gr57bny4',
        'publicKey' => 'dbwbwtn4jctgmjx4',
        'privateKey' => '6b780d616cd41773c6d2c21692b694a0'
    ]);

    $token = $gateway->ClientToken()->generate();

    return response()->json([
        'success' => true,
        'results' => $token
    ]);
});
