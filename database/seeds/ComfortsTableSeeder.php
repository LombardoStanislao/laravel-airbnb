<?php

use Illuminate\Database\Seeder;
use App\Comfort;

class ComfortsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $comforts = [
            'WiFi',
            'Posto Macchina',
            'Piscina',
            'Portineria',
            'Sauna',
            'Vista Mare'
        ];

        foreach ($comforts as $comfort) {
            $new_comfort = new Comfort();
            $new_comfort->name = $comfort;
            $new_comfort->save();
        }
    }
}
