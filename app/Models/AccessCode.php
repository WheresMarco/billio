<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessCode extends Model
{
    public $timestamps = false;

    protected $casts = ['valid_from' => 'datetime', 'valid_to' => 'datetime'];

    public function event()
    {
        return $this->belongsTo('App\Models\Event');
    }

    public function ticket_type()
    {
        return $this->belongsTo('App\Models\TicketType');
    }
}
