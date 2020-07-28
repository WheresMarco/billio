<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function single()
    {
        return view('event.purchase.single');
    }

    public function confirmation()
    {
        return view('event.purchase.confirmation');
    }
}
