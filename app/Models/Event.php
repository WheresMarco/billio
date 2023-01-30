<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Whitecube\NovaFlexibleContent\Concerns\HasFlexible;

class Event extends Model
{
    use HasFlexible;

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
        // Return ticket types sort by sorting order
        return $this->hasMany('App\Models\TicketType')->orderBy('sorting_order');
    }

    public function access_codes()
    {
        return $this->hasMany('App\Models\AccessCode');
    }

    public function getDescription()
    {
        return $this->flexible('description');
    }
}
