<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    protected $fillable = [ 'apartment_id', 'date_view' ];

    public function apartment() {
        return $this->belongsTo('App\Apartment');
    }
}
