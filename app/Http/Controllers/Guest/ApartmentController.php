<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Apartment;
use App\Message;
use App\View;
use App\Image;

class ApartmentController extends Controller
{

    public function index()
    {
        return view('guest.apartments.index');
    }

    public function show($slug, Request $request)
    {
        $apartment = Apartment::where('slug', $slug)->first();

        if(!$apartment){
            abort(404);
        }

        $this->addViewIfCorrect($apartment->id, $request->session());

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

    private function addViewIfCorrect($apartmentId, $session) {
        //controlla se l'utente è loggato
        if(Auth::check()) {
            $userId = Auth::user()->id;

            // Controlla che l'appartamento trovato appartenga all'utente loggato
            if($apartment->user_id != $userId) {
                $this->addView($apartmentId);
            }
        } else {
            //Controllo che la variabile dedicata alla visualizzazione degli appartamenti esista
            if ($session->has('viewedApartments')) {
                $viewedApartments = $session->get('viewedApartments');
                if(!in_array($apartmentId, $viewedApartments)) {
                    $this->addView($apartmentId);
                    $viewedApartments[] = $apartmentId;
                    $session->put('viewedApartments', $viewedApartments);
                }
            } else {
                $this->addView($apartmentId);
                $session->put('viewedApartments', [ $apartmentId ]);
            }
        }

    }

    private function addView($apartmentId) {
        $newView = new View();
        $newView->apartment_id = $apartmentId;
        $newView->date_view = Carbon::now();

        $newView->save();
    }
}
