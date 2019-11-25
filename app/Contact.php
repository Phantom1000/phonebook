<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function locations()
    {
        return $this->hasMany('App\Location');
    }

    public function phones()
    {
        return $this->hasMany('App\Phone');
    }
}
