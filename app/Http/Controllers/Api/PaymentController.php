<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Braintree\Gateway;

class PaymentController extends Controller
{
    public function clientToken() {
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
    }
}
