<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventDate extends Model
{
    public function event()
    {
        return $this->belongsTo('App\Event');
    }
}
