<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Actions\Actionable;
use Illuminate\Notifications\Notifiable;
use Laravel\Scout\Searchable;

use App\Http\Controllers\TicketController;

class Ticket extends Model
{
    use Actionable, Notifiable, Searchable;
    protected $fillable = [
        'uuid',
        'ticket_code',
        'event_id',
        'user_id',
        'ticket_type_id',
        'utlized',
        'status',
        'price'
    ];

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
            $query->uuid = ( new TicketController() )->genTicketUUID();
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

    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }

    public function nin()
    {
        return $this->hasOne('App\Nin');
    }

    public function toSearchableArray()
    {
        $array = $this->toArray();

        // $array['name']  = $this->user()->first()->name;
        // $array['email'] = $this->user()->first()->email;

        return $array;
    }
}
