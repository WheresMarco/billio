<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Frozzare\Personnummer\Personnummer;
use Illuminate\Support\Facades\Log;

use App\Nin;

class CheckStudentController extends Controller
{
    /**
     * Check if user is a student.
     *
     * @return void
     */
    public function check( Request $request )
    {
        // Sanitize input.
        $nin = $request->nin;

        // Check if student is member.
        $corps = $this->isStudentMember( $nin );

        // Return if member.
        return json_encode($corps);
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
        $isStudent = false;
        $corps = 'false';

        // Remove first two numbers if there is.
        if ( 12 === strlen( $nin ) )
        {
            $nin = substr( $nin, 2 );
        }

        // Check if NiN is valid.
        if ( ! Personnummer::valid( $nin ) )
        {
            Log::debug('Not valid ' . $nin );

            return false;
        }

        // TODO CHECK IF USED FOR THIS EVENT.

        // Do request.
        $isStudent = $this->sendRequest('https://medlem.lintek.liu.se/api/checkstudent/' . $nin . '?apikey=' . env( 'MONTANIA_API_KEY_LINTEK', null ), $nin);
        $corps = 'lintek';

        // No luck? Check Stuff.
        if ( ! $isStudent ) {
            $isStudent = $this->sendRequest('https://medlem.stuff.liu.se/api/checkstudent/' . $nin . '?apikey=' . env( 'MONTANIA_API_KEY_STUFF', null ), $nin);
            $corps = 'stuff';
        }

        // No luck? Check Consensus.
        if ( ! $isStudent ) {
            $isStudent = $this->sendRequest('https://medlem.consensus.liu.se/api/checkstudent/' . $nin . '?apikey=' . env( 'MONTANIA_API_KEY_CONSENSUS', null ), $nin);
            $corps = 'consensus';
        }

        // Add to database for quick lookup when buying ticket.
        if ( $isStudent ) {
            $nin_object = Nin::where( [ [ 'nin', $nin ], [ 'ticket_id', null ] ] )->first();

            if ( ! $nin_object ) :
                $nin_object = new Nin();
                $nin_object->nin = $nin;
                $nin_object->corps = $corps;
                $nin_object->utilized = false;
                $nin_object->save();
            endif;
        } else {
            $corps = 'false';
        }

        return $corps;
    }

    private function sendRequest($path, $nin)
    {
        // Set up object to call.
        $client = new \GuzzleHttp\Client();

        // Do request.
        $result = $client->request( 'GET', $path );

        // If not 200 status code exit out.
        if ( 200 !== $result->getStatusCode() )
        {
            Log::error('Cant access ' . $path );
            return false;
        }

        // Convert result to something we can work with.
        $content_string = (string) $result->getBody();
        $content        = json_decode($content_string);

        return $content->checkstudent->$nin->member;
    }
}
