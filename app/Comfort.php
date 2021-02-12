<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comfort extends Model
{
    public function apartments() {
        return $this->belongsToMany('App\Apartment');
    }
}
