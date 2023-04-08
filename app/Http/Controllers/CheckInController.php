<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class CheckInController extends Controller
{
    public function index()
    {
        return view('checkin');
    }
}
