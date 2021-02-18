<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Apartment;

class ApartmentController extends Controller
{

    public function index()
    {
        return view('guest.apartments.index');
    }

    public function show($slug)
    {
        $apartment = Apartment::where('slug', $slug)->first();

        if(!$apartment){
            abort(404);
        }
        $data = [
            'apartment' => $apartment
        ];

        return view('guest.apartments.show', $data);
    }

}
