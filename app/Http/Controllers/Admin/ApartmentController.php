<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Apartment;
use App\Comfort;
use App\Image;
use App\Sponsorship;
use App\SponsorshipType;
use App\View;
use App\Message;
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
            'street_number' => 'required|integer|min:1',
            'municipality' => 'required',
            'latitude' => 'required|numeric|min:-999.9999999|max:999.9999999',
            'longitude' => 'required|numeric|min:-999.9999999|max:999.9999999',
            'address' => 'nullable|max:255',
            'price_per_night' => 'required|numeric|min:0|max:9999.99',
            'image' => 'required|mimes:jpeg,png,jpg,gif,swg|max:2024',
            'images' => 'nullable|max:4',
            'images.*' => 'mimes:jpeg,png,jpg,gif,swg|max:2024',
            'comforts' => 'exists:comforts,id',
            'available' => 'required|boolean',
            'description' => 'nullable|max:65535'
        ]);

        $data = $request->all();

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

        if (array_key_exists('images', $data)) {

            foreach ($data["images"] as $image) {
                $secondary_images = Storage::put('apartment_images', $image);
                $new_apartment_image = new Image();
                $new_apartment_image->apartment_id = $new_apartment->id;
                $new_apartment_image->url = $secondary_images;
                $new_apartment_image->save();
            }

        }

        if (array_key_exists('comforts', $data)) {
            $new_apartment->comforts()->sync($data["comforts"]);
        }

        return redirect()->route('admin.apartments.show', ['apartment' => $new_apartment->id])->with('apartment-created', 'L\'appartamento è stato aggiunto con successo');
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
            $active_sponsorship = $apartment->sponsorships->sortBy('created_at')->last();
            if ($active_sponsorship) {
                $last_payment = $active_sponsorship->payments->sortBy('created_at')->last();
                if (!$last_payment->accepted) {
                    $active_sponsorship = null;
                } else {
                    $sponsorship_end = $active_sponsorship->created_at->addHours($active_sponsorship->sponsorshipType->duration);

                    if ($sponsorship_end <= Carbon::now()) {
                        $active_sponsorship = null;
                    }
                }
            }

            $data = [
                'apartment' => $apartment,
                'active_sponsorship' => $active_sponsorship,
                'images' => Image::where('apartment_id', $apartment->id)->get(),
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
                'images' => Image::where('apartment_id', $apartment->id)->get(),
                'comforts' => Comfort::all(),
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
        $oldImages = Image::where('apartment_id', $apartment->id)->get();
        $maxNumNewImages = 4 - $oldImages->count();

        $request->validate([
            'title' => 'required|max:255',
            'rooms_number' => 'required|integer|min:1|max:255',
            'sleeps_accomodations' => 'required|integer|min:1|max:255',
            'bathrooms_number' => 'required|integer|min:1|max:255',
            'mq' => 'required|integer|min:1|max:255',
            'street_name' => 'required',
            'street_number' => 'required|integer|min:1',
            'municipality' => 'required',
            'latitude' => 'required|numeric|min:-999.9999999|max:999.9999999',
            'longitude' => 'required|numeric|min:-999.9999999|max:999.9999999',
            'address' => 'nullable|max:255',
            'price_per_night' => 'required|numeric|min:0|max:9999.99',
            'image' => 'mimes:jpeg,png,jpg,gif,swg|max:2024',
            'old_images' => 'nullable|max:4',
            'old_images.*' => 'mimes:jpeg,png,jpg,gif,swg|max:2024',
            'new_images' => 'nullable|max:' . $maxNumNewImages,
            'new_images.*' => 'mimes:jpeg,png,jpg,gif,swg|max:2024',
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

        if(array_key_exists('image', $data)){
            $main_image = Storage::put('apartment_images', $data["image"]);
            $data["main-image"] = $main_image;
        }

        if (array_key_exists('old_images', $data)) {
            foreach ($oldImages as $index => $oldImage) {
                if (array_key_exists($index, $data['old_images'])) {
                    $oldImage->delete();
                }
            }
            foreach ($data['old_images'] as $image) {
                $secondary_images = Storage::put('apartment_images', $image);
                $new_apartment_image = new Image();
                $new_apartment_image->apartment_id = $apartment->id;
                $new_apartment_image->url = $secondary_images;
                $new_apartment_image->save();
            }
        }


        if (array_key_exists('new_images', $data)) {
            foreach ($data['new_images'] as $image) {
                $secondary_images = Storage::put('apartment_images', $image);
                $new_apartment_image = new Image();
                $new_apartment_image->apartment_id = $apartment->id;
                $new_apartment_image->url = $secondary_images;
                $new_apartment_image->save();
            }
        }

        $apartment->update($data);

        if (array_key_exists('comforts', $data)) {
            $apartment->comforts()->sync($data["comforts"]);
        }

        return redirect()->route('admin.apartments.show', ['apartment' => $apartment->id])->with('apartment-modified', 'L\'appartamento è stato modificato con successo');

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

        return back()->with('confirm-deletion', "L'appartamento " . $apartment->id . " è stato eliminato con successo");
    }

    public function statistics($apartment_id) {
        $apartment = Apartment::where('id', $apartment_id)->first();

        if ($apartment && $apartment->user_id == Auth::user()->id) {
            $data = [
                'views' => View::where('apartment_id', $apartment->id)->get(),
                'messages' => Message::where('apartment_id', $apartment->id)->get(),
                'apartment_id' => $apartment_id
            ];

            return view('admin.apartments.statistics', $data);
        }

        abort(404);
    }
}
