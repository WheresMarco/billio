<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nin extends Model
{
    protected $fillable = [
        'nin',
        'corps',
        'ticket_id',
        'utilized',
    ];

    public function event()
    {
        return $this->belongsTo('App\Models\Ticket');
    }
}
