<?php

namespace App\Models;

use App\Http\Controllers\TicketController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Nova\Actions\Actionable;
use Laravel\Scout\Searchable;
use Illuminate\Support\Str;

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
        'price',
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
            $query->uuid = Str::uuid();
        });
    }

    public function ticket_type()
    {
        return $this->belongsTo('App\Models\TicketType');
    }

    public function event()
    {
        return $this->belongsTo('App\Models\Event');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function modifiers()
    {
        return $this->morphToMany('App\Models\Modifier', 'ticket_modifiers');
    }

    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction');
    }

    public function customFields()
    {
        return $this->hasMany('App\Models\TicketCustomField');
    }

    public function nin()
    {
        return $this->hasOne('App\Models\Nin');
    }

    public function toSearchableArray()
    {
        $array = $this->toArray();

        // $array['name']  = $this->user()->first()->name;
        // $array['email'] = $this->user()->first()->email;

        return $array;
    }
}
