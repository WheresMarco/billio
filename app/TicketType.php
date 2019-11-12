<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketType extends Model
{
    public $timestamps = false;

    public function event()
    {
        return $this->belongsTo('App\Event');
    }

    public function tickets()
    {
        return $this->hasMany('App\Ticket');
    }

    public function modifiers()
    {
        return $this->hasMany('App\Modifier');
    }
}
