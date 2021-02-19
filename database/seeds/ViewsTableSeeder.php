<?php

use Illuminate\Database\Seeder;

use App\View;
use App\Apartment;
use Carbon\Carbon;

class ViewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 200; $i++) {

            $apartments = Apartment::all();
            $maxId = Apartment::orderBy('id', 'desc')->first()->id;

            $apartment = 0;
            while(!$apartment) {
                $apartment = $apartments->find(rand(1, $maxId));
            }

            $newView = new View();
            $newView->apartment_id = $apartment->id;
            // simulating a date between now and 3 years ago
            $simulatedDate = Carbon::now()->sub('years', rand(0, 2))->sub('months', rand(0, 11))->sub('days', rand(0, 31));
            $newView->date_view = $simulatedDate;

            $newView->save();
        }

    }
}
