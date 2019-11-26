<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventDate extends Model
{
    public $timestamps = false;

    protected $casts = ['date_from' => 'datetime', 'date_to' => 'datetime'];

    public function event()
    {
        return $this->belongsTo('App\Event');
    }
}
