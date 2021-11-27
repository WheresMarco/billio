<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Event extends Model
{
    public $timestamps = false;

    /**
     * Check if upcoming date.
     *
     * @return void
     */
    public function upcoming()
    {
        return count($this->event_dates()->get()) > 0 ? $this->event_dates()->get()[0]->date_to >= (new Carbon) : null;
    }

    public function organisation()
    {
        return $this->belongsTo('App\Models\Organisation');
    }

    public function event_dates()
    {
        return $this->hasMany('App\Models\EventDate');
    }

    public function access_codes()
    {
        return $this->hasMany('App\Models\AccessCode');
    }

    public function tickets()
    {
        return $this->hasMany('App\Models\Ticket');
    }

    public function ticket_types()
    {
        return $this->hasMany('App\Models\TicketType');
    }
}
