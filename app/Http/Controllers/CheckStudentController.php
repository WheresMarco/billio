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

        // Check if student is member.
        $member = $this->isStudentMember( $nin );

        // Return if member.
        return [
            'data'  => $member,
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }

    /**
     * Check if student is member.
     *
     * @param [type] $nin
     * @return boolean
     */
    public function isStudentMember( $nin )
    {
        $nin = str_replace( '-', '', $nin);

        // Remove first two numbers if there is.
        if ( 12 === strlen( $nin ) )
        {
            $nin = substr( $nin, 2 );
        }

        // Check if NiN is valid.
        if ( ! Personnummer::valid( $nin ) )
        {
            // TODO Error log
            return false;
        }

        // Set up object to call.
        $client = new \GuzzleHttp\Client();

        // Do request.
        $result = $client->request( 'GET', 'https://medlem.lintek.liu.se/api/checkstudent/' . $nin . '?apikey=' . env( 'MONTANIA_API_KEY', null ) );

       // If not 200 status code exit out.
       if ( 200 !== $result->getStatusCode() )
       {
           // TODO Error log
           return false;
       }

       // Convert result to something we can work with.
       $content_string = (string) $result->getBody();
       $content        = json_decode($content_string);

       // TODO Add checks for Stuff and Consenus if false.

       return $content->checkstudent->$nin->member;
    }
}
