<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    public function ticket_type()
    {
        return $this->belongsTo('App\TicketType');
    }

    public function modifiers()
    {
        return $this->morphToMany('App\Modifier', 'ticket_modifiers');
    }
}
