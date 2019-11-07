<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckStudentController extends Controller
{
    /**
     * Check if user is a student.
     *
     * @return void
     */
    public function check( Request $request )
    {
        $nin = $request->nin;

        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'https://medlem.lintek.liu.se/api/checkstudent/' . $nin . '?apikey=' . env('MONTANIA_API_KEY', null));

        return $res->getBody();
    }
}
