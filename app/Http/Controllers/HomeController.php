<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

use App\Apartment;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        return view('guest.home');
    }

    public function search($location) {
        // //get all the apartments in the DB
        // $apartments = Apartment::all();
        //
        // //Array with the positions of all the apartments in the DB
        // $poiList=[];
        // foreach ($aparments as $apartment) {
        //     $poiList[] = [
        //         "lat" => $apartment->latitude,
        //         "lon" => $apartment->longitude
        //     ];
        // }

        $baseURL = 'https://api.tomtom.com/search/2/';
        $key = 'uh1InUaJszlyTvCRilNBbn0pPm2ktvmD';

        $URLCoordinartesSearched = $baseURL . 'geocode/' . Str::slug($location) . '.json';
        //
        $responseLocation = Http::get($URLCoordinartesSearched, [
            'key' => 'uh1InUaJszlyTvCRilNBbn0pPm2ktvmD'
        ]);

        $lat = $responseLocation->json()['results'][0]['position']['lat'];
        $lon = $responseLocation->json()['results'][0]['position']['lon'];

        $searchedPosition = $lat . ',' . $lon;
        dd($searchedPosition);

        // $geometryList = [
        //     'type' => 'CIRCLE',
        //     'position' => '' ,
        //     'radius' => 20000
        // ];
        // $URLFilteredApartments = 'https://api.tomtom.com/search/2/geometryFilter.JSON?key=uh1InUaJszlyTvCRilNBbn0pPm2ktvmD';
        //
        // $responseFilteredApartments = Http::post($URLFilteredApartments, [
        //     'poiList' => $poiList
        // ]);
    }
}
