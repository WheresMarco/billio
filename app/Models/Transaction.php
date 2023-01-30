<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'purchase_id',
        'user_id',
        'amount',
        'stripe_id',
        'access_code',
        'purchase_type',
    ];

    public function ticket()
    {
        return $this->belongsTo('App\Models\Ticket', 'purchase_id');
    }

    public function donation()
    {
        return $this->belongsTo('App\Models\Donation', 'purchase_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
