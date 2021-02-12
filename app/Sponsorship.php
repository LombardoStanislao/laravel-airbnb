<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sponsorship extends Model
{
    public function apartment() {
        return $this->belongsTo('App\Apartment');
    }

    public function sponsorshipType() {
        return $this->belongsTo('App\SponsorshipType');
    }

    public function payments() {
        return $this->hasMany('App\Payment');
    }
}
