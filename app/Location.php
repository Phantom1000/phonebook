<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $guarded = [];

    public function contact()
    {
        return $this->belongsTo('App\Contact');
    }
}
