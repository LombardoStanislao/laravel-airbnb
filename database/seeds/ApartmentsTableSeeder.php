<?php

use Illuminate\Database\Seeder;
use App\Apartment;
use Faker\Generator as Faker;

class ApartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        //Cambiare i valori a seconda della zona in cui si desiderano inserire gli Appartamenti
        $minLat = 40.8;
        $maxLat = 41.1;
        $minLon = 14.2;
        $maxLon = 14.5;
        for ($i = 0; $i < 10; $i++) {
            $newApartment = new Apartment();
            $newApartment->user_id = 1;
            $newApartment->rooms_number = rand(1, 6);
            $newApartment->sleeps_accomodations = rand(2, 15);
            $newApartment->title = $faker->words(rand(2, 6), true);
            $newApartment->slug = Str::slug($newApartment->title);
            $newApartment->description = $faker->text;
            $newApartment->{'main-image'} = 'apartment_images/zNodnvut7vx2GDTYIKpSmj3sza2sb2KDYw8KUnx4.jpg';
            $newApartment->bathrooms_number = rand(1, 5);
            $newApartment->mq = rand(25, 200);
            $newApartment->latitude = $faker->randomFloat(7, $minLat, $maxLat);
            $newApartment->longitude = $faker->randomFloat(7, $minLon, $maxLon);
            $newApartment->price_per_night = $faker->randomFloat(2, 20, 500);

            $newApartment->save();
        }
    }
}
