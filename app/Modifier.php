<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modifier extends Model
{
    public $timestamps = false;

    public function tickets()
    {
        return $this->morphedByMany('App\Ticket', 'ticket_modifiers');
    }

    public function ticket_type()
    {
        return $this->belongsTo('App\TicketType');
    }
}
