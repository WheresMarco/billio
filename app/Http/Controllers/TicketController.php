<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\AccessCode;
use App\Event;
use App\Ticket;
use App\TicketType;
use App\User;
use App\Modifier;

class TicketController extends Controller
{
    /**
     * Get ticket by id.
     *
     * @return void
     */
    public function ticket( Request $request, $id )
    {
        return 'not implemented';
    }

    /**
     * Get a users tickets.
     *
     * @return void
     */
    public function user_tickets( Request $request, int $id )
    {
        return 'not implemented';
    }

    /**
     * Create ticket.
     *
     * @return void
     */
    public function create( Request $request )
    {

        $accessCode   = $request->accessCode;
        $email        = $request->email;
        $firstName    = $request->firstName;
        $lastName     = $request->lastName;
        $eventID      = $request->eventID;
        $ticketTypeID = $request->ticketTypeID;
        $ticketModifierID = $request->ticketModifierID; // TODO Get as array.

        // Check if event is valid.
        $event = Event::find( $eventID );
        if ( null === $event )
        {
            return 'false';
        }

        // Check if ticket type is valid.
        $ticketType = TicketType::find( $ticketTypeID );
        if ( null === $ticketType )
        {
            return 'false2';
        }

        // Check if you have an access code.
        if ( $accessCode )
        {
            $accessCode = AccessCode::find( $accessCode ); // TODO Find by code
        }

        // Check if ticket type is active.
        if ( ! $ticketType->active )
        {
            if ( $accessCode && $event->id === $accessCode->event_id )
            {
                // TODO Implement
            } else
            {
                return 'Not active';
            }
        }

        // Get ticket price.
        $price = $ticketType->price;

        // TODO Calculate price based on modifiers.
        // TODO Get modifers based on ID and do magic with price.

        // Check if there are any tickets left.
        $ticketsSold = $this->ticketsSold( $event->id, $ticketType->id );

        if ( $ticketsSold >= $ticketType->limit )
        {
            return 'no tickets left';
        }

        // Get user.
        $user = User::where( 'email', $email )->first();

        // If no user, create.
        if ( ! $user )
        {
            $user = new User();
            $user->email = $email;
            $user->name = $firstName . ' ' . $lastName;
            $user->save();
        }

        // Create UUID for ticket id.
        $uuid = $this->gen_uuid();

        // Create ticket.
        $ticket                 = new Ticket();
        $ticket->uuid           = $uuid;
        $ticket->event_id       = $event->id;
        $ticket->user_id        = $user->id;
        $ticket->ticket_type_id = $ticketType->id;
        $ticket->status         = 'unpaid';
        $ticket->price          = $price;
        $ticket->save();

        // TODO Loop over all modfiers and save on ticket
        $modifier = Modifier::find($ticketModifierID);
        $ticket->modifiers()->save($modifier);

        // Build and return the ticket array.
		$return_array = array(
		    'data'  => array(
			    'id'        => $ticket->uuid,
				'eventID'   => $event->id,
				'status'    => 'unpaid',
				'user'      => array(
					'id'            => $user->id,
					'name'          => $user->name,
					'email'         => $user->email,
				),
			)
		);

        // Return ticket to API.
        return $return_array;
    }

    /**
     * Update ticket.
     *
     * @return void
     */
    public function update( Request $request, int $id )
    {
        return 'not implemented';
    }

    /**
     * Delete ticket.
     *
     * @return void
     */
    public function delete( Request $request, int $id )
    {
        return 'not implemented';
    }

    public function ticketsSold( $eventID, $ticketTypeID )
    {
        $tickets     = Ticket::where( [ [ 'event_id', $eventID ] ])->get(); // TODO Add ticket type ID
        $ticketsSold = $tickets->count();

        return $ticketsSold;
    }

    /**
    * Generates a unique ID
    *
    * @since    1.0.0
    * @access   public
    * @return   string
    */
    public function gen_uuid() {
       $uuid = null;

       while ( null === $uuid ) :
           $temp_uuid = sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
               rand( 0, 0xffff ), rand( 0, 0xffff ), // 32 bits for "time_low"
               rand( 0, 0xffff ), // 16 bits for "time_mid"
               rand( 0, 0x0fff ) | 0x4000, // 16 bits for "time_hi_and_version", four most significant bits holds version number 4
               rand( 0, 0x3fff ) | 0x8000, // 16 bits, 8 bits for "clk_seq_hi_res", 8 bits for "clk_seq_low", two most significant bits holds zero and one for variant DCE1.1
               rand( 0, 0xffff ), rand( 0, 0xffff ), rand( 0, 0xffff ) // 48 bits for "node"
           );

           // Check if taken, if not assign to $uuid.
           $ticket = Ticket::where( 'uuid', $temp_uuid )->first();
           if ( ! $ticket ) :
               $uuid = $temp_uuid;
           endif;
       endwhile;

       return $uuid;
   }
}
