<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    protected $fillable = [
        'user_id',
        'rooms_number',
        'sleeps_accomodations',
        'title',
        'slug',
        'description',
        'main-image',
        'bathrooms_number',
        'mq',
        'latitude',
        'longitude',
        'address',
        'available',
        'price_per_night'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function views() {
        return $this->hasMany('App\View');
    }

    public function messages() {
        return $this->hasMany('App\Message');
    }

    public function images() {
        return $this->hasMany('App\Image');
    }

    public function sponsorships() {
        return $this->hasMany('App\Sponsorship');
    }

    public function comforts() {
        return $this->belongsToMany('App\Comfort');
    }
}
