<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApartmentController extends Controller
{

    public function index()
    {
        return view('guest.apartments.index');
    }

    public function show($id)
    {
        return view('guest.apartments.show');
    }

}
