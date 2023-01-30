<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'donation_type_id',
        'user_id',
        'event_id',
        'amount',
    ];

    public function donation_type()
    {
        return $this->belongsTo('App\Models\DonationType');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function event()
    {
        return $this->belongsTo('App\Models\Event');
    }
}
