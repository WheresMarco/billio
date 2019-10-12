<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function organisation()
    {
        return $this->belongsTo('App\Organisation');
    }

    public function dates()
    {
        return $this->hasMany('App\EventDate');
    }
}
