<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Message;
use App\Apartment;
use Carbon\Carbon;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i < 10; $i++) {
            $newMessage = new Message();
            $newMessage->mail_sender = $faker->email();
            $newMessage->body_message = $faker->text();

            $apartment = null;
            $maxId = Apartment::orderBy('id', 'desc')->first()->id;
            while(!$apartment) {
                $apartment = Apartment::find(rand(1, $maxId));
            }

            $newMessage->apartment_id = $apartment->id;
            // simulating a date between now and 3 years ago
            $simulatedDate = Carbon::now()->sub('years', rand(0, 2))->sub('months', rand(0, 11))->sub('days', rand(0, 31));
            $newMessage->date_message = $simulatedDate;

            $newMessage->save();
        }
    }
}
