<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'event_id',
        'ticket_type_id',
        'ticket_id',
        'used',
    ];

    protected $casts = [
        'valid_from' => 'datetime',
        'valid_to' => 'datetime',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
