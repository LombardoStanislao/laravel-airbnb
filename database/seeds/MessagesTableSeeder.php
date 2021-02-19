<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Message;
use App\Apartment;

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

            $newMessage->save();
        }
    }
}
