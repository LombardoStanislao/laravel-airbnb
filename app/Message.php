<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [ "body_message", "mail_sender", "apartment_id", 'is_new' ];

    public function apartment() {
        return $this->belongsTo('App\Apartment');
    }
}
