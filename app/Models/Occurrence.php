<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Occurrence extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'date_from',
        'date_to',
        'location',
        'ticket_limit',
    ];

    protected $casts = ['date_from' => 'datetime', 'date_to' => 'datetime'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function getTicketLimitLeftAttribute()
    {
        return $this->ticket_limit - $this->tickets()->count();
    }

    public function getIsSoldOutAttribute()
    {
        return $this->ticket_limit_left === 0;
    }
}
