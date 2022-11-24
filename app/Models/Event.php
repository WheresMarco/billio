<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Event extends Model
{
    public $timestamps = false;

    protected $casts = ['date_from' => 'datetime', 'date_to' => 'datetime'];

    /**
     * Check if upcoming date.
     *
     * @return void
     */
    public function upcoming()
    {
        return $this->date_to && Carbon::parse($this->date_to)->isFuture();
    }

    public function organisation()
    {
        return $this->belongsTo('App\Models\Organisation');
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
