<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class FrontpageController extends Controller
{
    /**
     * Show the frontpage.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('frontpage', [
            'events' => Event::all(),
        ]);
    }
}
