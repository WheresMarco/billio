<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketCustomField extends Model
{
    protected $fillable = [
        'name',
        'value',
    ];

    public function ticket()
    {
        return $this->belongsTo('App\Models\Ticket');
    }

}
