<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Apartment;
use App\Message;
use App\Image;

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
            'apartment' => $apartment,
            'images' => Image::where('apartment_id', $apartment->id)->get(),
        ];

        return view('guest.apartments.show', $data);
    }

    public function message($slug)
    {
        $apartment = Apartment::where('slug', $slug)->first();

        if(!$apartment){
            abort(404);
        }
        $data = [
            'apartment' => $apartment
        ];

        return view('guest.apartments.message', $data);
    }

    public function SendMessage($slug, Request $request)
    {
        $request->validate([
            'mail_sender' => 'required|string|email|max:255',
            'body_message' => 'required|string|max:65535'
        ]);

        $newMessage = new Message();
        $newMessage->fill($request->all());
        $newMessage->date_message = Carbon::now();
        $newMessage->save();

        $apartment = Apartment::find($request->input('apartment_id'));

        return redirect()->route('guest.apartments.show', [ 'slug' => $apartment->slug ]);

    }
}
