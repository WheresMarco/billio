<?php

namespace App\Models;

use App\Http\Controllers\TicketController;
use Illuminate\Database\Eloquent\Model;
use Whitecube\NovaFlexibleContent\Concerns\HasFlexible;
use Illuminate\Support\Str;

class TicketType extends Model
{
    use HasFlexible;

    public $timestamps = false;

    protected $appends = ['modifiers', 'sold_out'];

    public function event()
    {
        return $this->belongsTo('App\Models\Event');
    }

    public function tickets()
    {
        return $this->hasMany('App\Models\Ticket');
    }

    public function modifiers()
    {
        return $this->morphToMany('App\Models\Modifier', 'modifiables');
    }

    public function getModifiersAttribute()
    {
        $modifiers = $this->modifiers()->get();

        return $modifiers;
    }

    public function getSoldOutAttribute()
    {
        $tickets_sold = ( new TicketController() )->ticketsSold($this->event_id, $this->id);

        return $this->limit <= $tickets_sold;
    }

    public function getCustomFields()
    {
        return $this->flexible('custom_fields');
    }
}
