<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;
use App\Apartment;

class ApartmentController extends Controller
{
    public function filteredSearch(Request $request) {

        $baseURL = 'https://api.tomtom.com/search/2/';
        $key = 'uh1InUaJszlyTvCRilNBbn0pPm2ktvmD';

        /*get the searched location*/

        //apiURL request
        $URLCoordinartesSearched = $baseURL . 'geocode/' . $request->locationName . '.json';

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
                'radius' => $request->query()['radius']
            ]
        ];

        //get filtered apartments in the DB
        $selectedComforts = [];
        for ($i = 0; $i < strlen($request->query()['comfortIdString']); $i++) {
            $selectedComforts[] = $request->query()['comfortIdString'][$i];
        }

        $apartments = Apartment::where([
            ['sleeps_accomodations', '>=',  $request->query()['minimumSleepsAccomodations']],
            ['rooms_number', '>=', $request->query()['minimumRooms']]
        ])->get();

        // Array with the positions of all the apartments in the DB
        $poiList=[];

        foreach ($apartments as $apartment) {
            $rightComfortsNumber = $apartment->comforts->whereIn('id', $selectedComforts)->count();
            $comfortQuantity = count($selectedComforts);

            if($rightComfortsNumber == count($selectedComforts)) {
                $poiList[] = [
                    'position' => [
                        "lat" => $apartment->latitude,
                        "lon" => $apartment->longitude
                    ]
                ];
            }
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

        return response()->json([
            'success' => true,
            'results' => $filteredApartments
        ]);
    }
}
