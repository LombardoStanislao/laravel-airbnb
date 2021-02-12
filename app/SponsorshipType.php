<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SponsorshipType extends Model
{
    public function sponsorships() {
        return $this->hasMany('App\Sponsorship');
    }
}
