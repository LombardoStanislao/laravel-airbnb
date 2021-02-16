<?php

use Illuminate\Database\Seeder;
use App\SponsorshipType;

class SponsorshipTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sponsorship_types = [
            [
                'base',
                24,
                2.99,
            ],
            [
                'standard',
                72,
                5.99,
            ],
            [
                'pro',
                144,
                9.99,
            ],
        ];


        foreach ($sponsorship_types as $sponsorship_type) {
            $new_sponsorship_types = new SponsorshipType();
            $new_sponsorship_types->type_name = $sponsorship_type[0];
            $new_sponsorship_types->duration = $sponsorship_type[1];
            $new_sponsorship_types->price = $sponsorship_type[2];
            $new_sponsorship_types->save();
        }


    }
}
