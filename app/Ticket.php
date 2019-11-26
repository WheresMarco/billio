<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Http\Controllers\TicketController;

class Ticket extends Model
{
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // auto-sets values on creation
        static::creating(function ($query) {
            $query->uuid = ( new TicketController() )->genUUID();
        });
    }

    public function ticket_type()
    {
        return $this->belongsTo('App\TicketType');
    }

    public function event()
    {
        return $this->belongsTo('App\Event');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function modifiers()
    {
        return $this->morphToMany('App\Modifier', 'ticket_modifiers');
    }
}
