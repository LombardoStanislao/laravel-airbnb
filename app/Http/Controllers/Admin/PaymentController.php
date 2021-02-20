<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Braintree\Gateway;
use App\Apartment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\SponsorshipType;
use App\Payment;
use App\Sponsorship;

class PaymentController extends Controller
{
    public function pay($id) {
        $apartment = Apartment::where('id', $id)->first();

        if ($apartment && $apartment->user_id == Auth::user()->id && !isSponsored($apartment)) {
            $data = [
                'sponsorship_types' => SponsorshipType::all(),
                'apartment_id' => $id
            ];

            return view('admin.apartments.sponsorship', $data);
        }

        abort(404);
    }


    public function checkout($apartment_id, Request $request) {
        $request->validate([
            'sponsorship_type_id' => 'required|exists:sponsorship_types,id'
        ]);

        $gateway = new Gateway([
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

    }
}
