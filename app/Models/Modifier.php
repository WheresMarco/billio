<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modifier extends Model
{
    public $timestamps = false;

    public function tickets()
    {
        return $this->morphedByMany('App\Models\Ticket', 'ticket_modifiers');
    }
}
