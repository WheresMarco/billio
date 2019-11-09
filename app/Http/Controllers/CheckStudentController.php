<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Frozzare\Personnummer\Personnummer;

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
        $nin = str_replace( '-', '', $nin);

        // Check if NiN is valid.
        if ( ! Personnummer::valid( $nin ) )
        {
            return [
                'data'  => 'Not valid',
                'links' => [
                    'self' => 'link-value',
                ],
            ];
        }

        // Set up object to call.
        $client = new \GuzzleHttp\Client();

        // Do request.
        $result = $client->request( 'GET', 'https://medlem.lintek.liu.se/api/checkstudent/' . $nin . '?apikey=' . env( 'MONTANIA_API_KEY', null ) );

        // If not 200 status code exit out.
        if ( 200 !== $result->getStatusCode() )
        {
            return [
                'data' => 'API Unavailable',
                'links' => [
                    'self' => 'link-value',
                ],
            ];
        }

        // Convert result to something we can work with.
        $content_string = (string) $result->getBody();
        $content        = json_decode($content_string);

        // TODO Add checks for Stuff and Consenus if false.

        // Return if member.
        return [
            'data'  => $content->checkstudent->$nin->member,
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
