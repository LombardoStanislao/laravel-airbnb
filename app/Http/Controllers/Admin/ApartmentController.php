<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Apartment;
use App\Comfort;
use App\Sponsorship;
use App\SponsorshipType;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'apartments' => Apartment::where('user_id', Auth::user()->id)->get(),

        ];
        return view('admin.apartments.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'comforts' => Comfort::all()
        ];
        return view('admin.apartments.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'rooms_number' => 'required|integer|min:1|max:255',
            'sleeps_accomodations' => 'required|integer|min:1|max:255',
            'bathrooms_number' => 'required|integer|min:1|max:255',
            'mq' => 'required|integer|min:1|max:255',
            'street_name' => 'required',
            'street_number' => 'required|min:1',
            'municipality' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'price_per_night' => 'required|numeric|min:0|max:9999.99',
            'image' => 'mimes:jpeg,png,jpg,gif,swg|max:2024',
            'comforts' => 'exists:comforts,id',
            'available' => 'required|boolean',
            'description' => 'nullable|max:65535'
        ]);

        $data = $request->all();

        // dd($data["sponsorship_types"][0]);

        $data["user_id"] = Auth::user()->id;

        $slug = Str::slug($data["title"], '-');
        $new_slug = $slug;
        $slug_found = Apartment::where('slug', $new_slug)->first();
        $counter = 1;
        while ($slug_found) {
            $new_slug = $slug . '-' . $counter;
            $counter++;
            $slug_found = Apartment::where('slug', $new_slug)->first();
        }
        $data["slug"] = $new_slug;

        $main_image = Storage::put('apartment_images', $data["image"]);
        $data["main-image"] = $main_image;

        $new_apartment = new Apartment();
        $new_apartment->fill($data);
        $new_apartment->save();

        if (array_key_exists('comforts', $data)) {
            $new_apartment->comforts()->sync($data["comforts"]);
        }

        return redirect()->route('admin.apartments.show', ['apartment' => $new_apartment->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function payments()
    {
        return view('admin.apartments.payments');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Apartment $apartment)
    {
        if ($apartment && $apartment->user_id == Auth::user()->id) {
            $last_sponsorship = $apartment->sponsorships->sortByDesc('created_at')->first();
            if ($last_sponsorship) {
                $sponsorship_end = $last_sponsorship->created_at->addHours($last_sponsorship->sponsorshipType->duration);
                $has_active_sponsorship = $sponsorship_end > Carbon::now();
            } else {
                $has_active_sponsorship = false;
            }

            $data = [
                'apartment' => $apartment,
                'has_active_sponsorship' => $has_active_sponsorship,
                'sponsorship_types' => SponsorshipType::all()
            ];

            return view('admin.apartments.show', $data);
        }

        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Apartment $apartment)
    {
        if ($apartment && $apartment->user_id == Auth::user()->id) {
            $data = [
                'apartment' => Apartment::where('id', $apartment->id)->first(),
                'comforts' => Comfort::all()
            ];

            return view('admin.apartments.edit', $data);
        }

        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Apartment $apartment)
    {
        $request->validate([
            'title' => 'required|max:255',
            'rooms_number' => 'required|integer|min:1|max:255',
            'sleeps_accomodations' => 'required|integer|min:1|max:255',
            'bathrooms_number' => 'required|integer|min:1|max:255',
            'mq' => 'required|integer|min:1|max:255',
            'street_name' => 'required',
            'street_number' => 'required|min:1',
            'municipality' => 'required',
            'price_per_night' => 'required|numeric|min:0|max:9999.99',
            'image' => 'mimes:jpeg,png,jpg,gif,swg|max:2024',
            'comforts' => 'exists:comforts,id',
            'available' => 'required|boolean',
            'description' => 'nullable|max:65535',
        ]);

        $data = $request->all();

        $data["user_id"] = Auth::user()->id;

        if($data['title'] != $apartment->title){
            $slug = Str::slug($data["title"], '-');
            $new_slug = $slug;
            $slug_found = Apartment::where('slug', $new_slug)->first();
            $counter = 1;
            while ($slug_found) {
                $new_slug = $slug . '-' . $counter;
                $counter++;
                $slug_found = Apartment::where('slug', $new_slug)->first();
            }
            $data["slug"] = $new_slug;
        }

        if(array_key_exists('image',$data)){
            $main_image = Storage::put('apartment_images', $data["image"]);
            $data["main-image"] = $main_image;
        }

        $apartment->update($data);

        if (array_key_exists('comforts', $data)) {
            $apartment->comforts()->sync($data["comforts"]);
        }

        return redirect()->route('admin.apartments.show', ['apartment' => $apartment->id]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Apartment $apartment)
    {

        $apartment->comforts()->sync([]);

        $apartment->delete();

        return redirect()->route('admin.apartments.index');
    }
}
