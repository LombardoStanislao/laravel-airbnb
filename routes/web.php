<?php

use Illuminate\Support\Facades\Route;
use App\SponsorshipType;
use App\Sponsorship;
use App\Payment;
use Illuminate\Http\Request;

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

Route::get('/', 'HomeController@index')->name('home');
// Route::get('/advancedsearch', 'Guest\ApartmentController');

Route::get('/search', 'HomeController@search')->name('search');
Route::get('/apartments/{slug}', 'Guest\ApartmentController@show')->name('guest.apartments.show');
Route::get('/apartments/{slug}/message', 'Guest\ApartmentController@message')->name('guest.apartments.message');
Route::post('/apartments/{slug}/message', 'Guest\ApartmentController@sendMessage')->name('guest.apartments.sendMessage');

Auth::routes();

Route::middleware('auth')->prefix('admin')->namespace('Admin')->name('admin.')->group(function() {
    Route::get('/', 'HomeController@index')->name('index');
    Route::get('/apartments/payments', 'ApartmentController@payments')->name('apartments.payments');

    Route::get('/apartments/{id}/sponsorship', function ($id) {
        $gateway = new Braintree\Gateway([
            'environment' => 'sandbox',
            'merchantId' => 'n67d8y97gr57bny4',
            'publicKey' => 'dbwbwtn4jctgmjx4',
            'privateKey' => '6b780d616cd41773c6d2c21692b694a0'
        ]);

        $token = $gateway->ClientToken()->generate();

        $data = [
            'sponsorship_types' => SponsorshipType::all(),
            'apartment_id' => $id,
            'token' => $token
        ];

        return view('admin.apartments.sponsorship', $data);
    })->name('apartments.sponsorship');

    Route::post('/checkout/{apartment_id}', function($id, Request $request) {
        $gateway = new Braintree\Gateway([
            'environment' => 'sandbox',
            'merchantId' => 'n67d8y97gr57bny4',
            'publicKey' => 'dbwbwtn4jctgmjx4',
            'privateKey' => '6b780d616cd41773c6d2c21692b694a0'
        ]);

        $amount = $request->amount;
        $nonce = $request->payment_method_nonce;

        $result = $gateway->transaction()->sale([
            'amount' => $amount,
            'paymentMethodNonce' => $nonce,
            'options' => [
                'submitForSettlement' => true
            ]
        ]);

        if ($result->success) {
            $apartment_id = $id;

            $sponsorship_type = SponsorshipType::where('price', $amount)->first();

            $new_sponsorship = new Sponsorship();

            $new_sponsorship->apartment_id = $apartment_id;

            $new_sponsorship->sponsorship_type_id = $sponsorship_type->id;

            $new_sponsorship->save();

            $new_payment = new Payment();

            $new_payment->sponsorship_id = $new_sponsorship->id;

            $new_payment->save();

            $transaction = $result->transaction;

            return redirect()->route('admin.apartments.payments')->with('success_message', 'Transazione avvenuta con successo. Id transazione: ' . $transaction->id);
        }
    })->name('checkout');

    Route::resource('/apartments', 'ApartmentController');
});
