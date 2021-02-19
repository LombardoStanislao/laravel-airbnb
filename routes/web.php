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

    Route::get('/messages', 'MessageController@index')->name('messages.index');
    Route::get('/messages/{id}', 'MessageController@show')->name('messages.show');


    // *********** Braintree ***********
    Route::get('/apartments/{id}/sponsorship', function ($id) {
        $apartment = Apartment::where('id', $id)->first();

        if ($apartment) {
            $active_sponsorship = $apartment->sponsorships->sortBy('created_at')->last();

            if ($active_sponsorship) {
                $last_payment = $active_sponsorship->payments->sortBy('created_at')->last();
                if (!$last_payment->accepted) {
                    $active_sponsorship = null;
                } else {
                    $sponsorship_end = $active_sponsorship->created_at->addHours($active_sponsorship->sponsorshipType->duration);
                    if ($sponsorship_end <= Carbon::now()) {
                        $active_sponsorship = null;
                    }
                }
            }

            if (!$active_sponsorship) {
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
            }
        }

        abort(404);

    })->name('apartments.sponsorship');



    Route::post('/checkout/{apartment_id}', function($apartment_id, Request $request) {
        $gateway = new Braintree\Gateway([
            'environment' => 'sandbox',
            'merchantId' => 'n67d8y97gr57bny4',
            'publicKey' => 'dbwbwtn4jctgmjx4',
            'privateKey' => '6b780d616cd41773c6d2c21692b694a0'
        ]);

        $sponsorship_type = SponsorshipType::where('id', $request->sponsorship_type_id)->first();

        $amount = $sponsorship_type->price;

        $nonce = $request->payment_method_nonce;

        $apartment = Apartment::where('id', $apartment_id)->first();

        $customer = $apartment->user;

        $result = $gateway->transaction()->sale([
            'amount' => $amount,
            'paymentMethodNonce' => $nonce,
            'options' => [
                'submitForSettlement' => true
            ],
            'customer' => [
                'firstName' => $customer->name,
                'lastName' => $customer->lastname,
                'email' => $customer->email
            ]
        ]);

        $new_sponsorship = new Sponsorship();

        $new_sponsorship->apartment_id = $apartment_id;

        $new_sponsorship->sponsorship_type_id = $sponsorship_type->id;

        $new_sponsorship->save();

        $new_payment = new Payment();

        $new_payment->sponsorship_id = $new_sponsorship->id;

        if ($result->success) {

            $new_payment->accepted = 1;

            $new_payment->save();

            $transaction = $result->transaction;

            return redirect()->route('admin.apartments.show', ['apartment' => $apartment_id])->with('success_message', 'La transazione è avvenuta con successo. Id transazione: ' . $transaction->id);
        } else {
            $new_payment->accepted = 0;

            $new_payment->save();

            return back()->with('error_message', 'La transazione è fallita');
        }

    })->name('checkout');
});
