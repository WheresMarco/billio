<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'ticket_id',
        'user_id',
        'amount',
        'stripe_id',
        'access_code',
    ];

    public function ticket()
    {
        return $this->belongsTo('App\Models\Ticket');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
