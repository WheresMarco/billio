<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\TicketController;

class TicketType extends Model
{
    public $timestamps = false;

    protected $appends = ['sold_out'];

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

    public function getSoldOutAttribute()
    {
        $tickets_sold = ( new TicketController() )->ticketsSold($this->event_id, $this->id);

        return $this->limit <= $tickets_sold;
    }
}
