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

    public function occurrences()
    {
        return $this->belongsToMany('App\Models\Occurrence', 'ticket_type_occurrences');
    }

    public function modifiers()
    {
        // Return modifiers sorted by sorting_order
        return $this->hasMany('App\Models\Modifier')->orderBy('sorting_order');
    }

    public function getModifiersAttribute()
    {
        $modifiers = $this->modifiers()->get();

        return $modifiers;
    }

    public function getTicketsLeftAttribute()
    {
        $tickets_sold = ( new TicketController() )->ticketsSold($this->event_id, $this->id);

        return $this->limit - $tickets_sold;
    }

    public function getSoldOutAttribute()
    {
//        // Special SOF-checks
//        if (Str::contains($this->event->slug, 'sof')) {
//            if (Str::contains($this->slug, 'complete')) {
//                // Get the occurrences for this event by event_id
//                $occurrences = Occurrence::where('event_id', $this->event_id)->get();
//
//                foreach ($occurrences as $occurrence) {
//                    if ($occurrence->isSoldOut) {
//                        return true;
//                    }
//                }
//            }
//        }

        $tickets_sold = ( new TicketController() )->ticketsSold($this->event_id, $this->id);

        // Also check if all the occurrences are sold out
        $occurrences_sold_out = true;

        // Does this ticket type have occurrences? If not, it's not sold out
        if ($this->occurrences->count() == 0) {
            $occurrences_sold_out = false;
        }

        foreach ($this->occurrences as $occurrence) {
            if (!$occurrence->isSoldOut) {
                $occurrences_sold_out = false;
            }
        }

        return ($this->limit <= $tickets_sold) || $occurrences_sold_out;
    }

    public function getCustomFields()
    {
        return $this->flexible('custom_fields');
    }
}
