<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public $successStatus = 200;

    public function login(){
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('Billio App')-> accessToken;
            return response()->json(['success' => $success], $this-> successStatus);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }

    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this-> successStatus);
    }

    public function tickets(Request $request) {
        $user = auth()->guard('api')->user();

        $tickets = $user->tickets()->get();

        if ($tickets)
        {
            foreach ($tickets as $ticketKey => $ticket) {
                $event = $ticket->event()->first();
                $tickets[$ticketKey]['event'] = $event->name;
                $tickets[$ticketKey]['eventExcerpt'] = $event->excerpt;
            }
        }

        $return_array = array(
            'data'  => array(
                'id'      => 1,
                'tickets' => $tickets,
                'user'    => array(
                    'id'            => $user->id,
                    'name'          => $user->name,
                    'email'         => $user->email,
                ),
            )
        );

        return $return_array;
    }
}
