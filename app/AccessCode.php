<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccessCode extends Model
{
    public $timestamps = false;

    protected $casts = ['valid_from' => 'datetime', 'valid_to' => 'datetime'];

    public function event()
    {
        return $this->belongsTo('App\Event');
    }

    public function ticket_type()
    {
        return $this->belongsTo('App\TicketType');
    }
}
