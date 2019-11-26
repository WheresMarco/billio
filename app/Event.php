<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public $timestamps = false;

    public function organisation()
    {
        return $this->belongsTo('App\Organisation');
    }

    public function event_dates()
    {
        return $this->hasMany('App\EventDate');
    }

    public function access_codes()
    {
        return $this->hasMany('App\AccessCode');
    }

    public function tickets()
    {
        return $this->hasMany('App\Ticket');
    }
}
