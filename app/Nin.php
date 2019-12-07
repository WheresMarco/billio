<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nin extends Model
{
    public function event()
    {
        return $this->belongsTo('App\Ticket');
    }
}
