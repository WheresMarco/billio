<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'amount',
    ];

    public $timestamps = false;

    public function donations()
    {
        return $this->hasMany('App\Models\Donation');
    }

    public function event()
    {
        return $this->belongsTo('App\Models\Event');
    }
}
