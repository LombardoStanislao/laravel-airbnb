<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

use App\Apartment;
use App\Comfort;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $apartments = Apartment::all();

        $sponsored_apartments = $apartments->filter(function($apartment) {
            return isSponsored($apartment);
        });

        $non_sponsored_apartments = $apartments->filter(function($apartment) {
            return !isSponsored($apartment);
        });

        $data = [
            'sponsored_apartments' => $sponsored_apartments,
            'non_sponsored_apartments' => $non_sponsored_apartments
        ];

        return view('guest.home', $data);
    }

    public function search(Request $request) {
        $location = $request->input('location');

        $baseURL = 'https://api.tomtom.com/search/2/';
        $key = 'uh1InUaJszlyTvCRilNBbn0pPm2ktvmD';

        /*get the searched location*/

        //apiURL request
        $URLCoordinartesSearched = $baseURL . 'geocode/' . $location . '.json';

        //API request
        $responseLocation = Http::get($URLCoordinartesSearched, [
            'key' => 'uh1InUaJszlyTvCRilNBbn0pPm2ktvmD'
        ]);

        // getting latitude and longitude of the placed searched
        $lat = $responseLocation->json()['results'][0]['position']['lat'];
        $lon = $responseLocation->json()['results'][0]['position']['lon'];

        $searchedPosition = $lat . ',' . $lon;

        //Area where looking for the apartments
        $geometryList = [
            [
                'type' => 'CIRCLE',
                'position' => $searchedPosition ,
                'radius' => 20000
            ]
        ];

        //get all the apartments in the DB
        $apartments = Apartment::all();
        // Array with the positions of all the apartments in the DB
        $poiList=[];
        foreach ($apartments as $apartment) {
            $poiList[] = [
                'position' => [
                    "lat" => $apartment->latitude,
                    "lon" => $apartment->longitude
                ]
            ];
        }

        //get the pairs of right positions
        $URLFilteredApartments = $baseURL . 'geometryFilter.JSON?key=' . $key;

        // $URLFilteredApartments = 'https://api.tomtom.com/search/2/geometryFilter.JSON?key=uh1InUaJszlyTvCRilNBbn0pPm2ktvmD';
        $responseFilteredApartments = Http::post($URLFilteredApartments, [
            'poiList' => $poiList,
            'geometryList' => $geometryList
        ]);

        //create an array with all the right latitude and one with all the longitudes
        $lats = [];
        $lons = [];

        foreach ($responseFilteredApartments->json()['results'] as $result) {
            $lats[] = $result['position']['lat'];
            $lons[] = $result['position']['lon'];
        }

        //select the apartments where the latitude and longitude are in the arrays
        $filteredApartments = $apartments->whereIn('latitude', $lats)->whereIn('longitude', $lons);

        // sort the apartments so that those having an active sponsorship come before
        $filteredApartments = $filteredApartments->sort(function($a, $b) {
            return isSponsored($b) - isSponsored($a);
        });

        $data = [
            'apartments' => $filteredApartments,
            'locationName' => $location,
            'locationCoordinates' => $searchedPosition,
            'comforts' => Comfort::all()
        ];
        return view('guest.apartments.index', $data);
    }
}
