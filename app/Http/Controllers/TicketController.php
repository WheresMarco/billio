<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use Stripe;

use App\AccessCode;
use App\Event;
use App\Ticket;
use App\TicketType;
use App\User;
use App\Modifier;
use App\Nin;

class TicketController extends Controller
{
    /**
     * Get ticket by id or stripe source id.
     *
     * @return void
     */
    public function ticket( Request $request, $id )
    {
        $ticket = Ticket::where( 'uuid', $id )->first();
        $event = $ticket->event()->first();
        $user = $ticket->user()->first();

        // Build and return the ticket array.
        $return_array = [
            'id'         => $ticket->id,
            'event'      => $event->name,
            'ticketCode' => $ticket->ticket_code,
            'eventSlug'  => $event->slug,
            'status'     => $ticket->status,
            'variations' => array(),
            'user'       => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
            ],
        ];
        return $return_array;
    }

    /**
     * Create ticket.
     *
     * @return void
     */
    public function create( Request $request )
    {
        $accessCode      = $request->accessCode;
        $email           = $request->email;
        $nin             = $request->nin;
        $firstName       = $request->firstName;
        $lastName        = $request->lastName;
        $eventID         = $request->eventID;
        $ticketTypeID    = $request->ticketTypeID;
        $ticketModifiers = $request->modifiers;

        // Check if event is valid.
        $event = Event::find( $eventID );
        if ( null === $event )
        {
            return 'Could not find event.';
        }

        // Check if ticket type is valid.
        $ticketType = TicketType::find( $ticketTypeID );
        if ( null === $ticketType )
        {
            return 'Ticket type not valid.';
        }

        // Check if you have an access code.
        // if ( $accessCode )
        // {
        //     $accessCode = AccessCode::find( $accessCode ); // TODO Find by code
        // }

        // // Check if ticket type is active.
        // if ( ! $ticketType->active )
        // {
        //     if ( $accessCode && $event->id === $accessCode->event_id )
        //     {
        //         // TODO Implement
        //     } else
        //     {
        //         return 'Not active';
        //     }
        // }

        // Get ticket price.
        $price = $ticketType->price;

        // Check if student
        $nin_object = Nin::where( [ [ 'nin', $nin ], [ 'ticket_id', null ], [ 'utilized', false ] ] )->first();
        if ( $nin_object ) {
            $ticketModifiers[] = $nin_object->corps;
        }

        // Calculate price based on modifiers.
        if ( $ticketModifiers ) {
            foreach ($ticketModifiers as $ticketModifier) {
                $modifier = Modifier::where( [ [ 'ticket_type_id', $ticketTypeID ], [ 'slug', $ticketModifier ] ] )->first();
                if ( $modifier ) {
                    $price = $price + $modifier->delta;
                }
            }
        }

        // Check if there are any tickets left.
        $ticketsSold = $this->ticketsSold( $event->id, $ticketType->id );

        if ( $ticketsSold >= $ticketType->limit )
        {
            return 'No tickets left for this event.';
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

        // Create ticket.
        $ticket                 = new Ticket();
        $ticket->event_id       = $event->id;
        $ticket->user_id        = $user->id;
        $ticket->ticket_type_id = $ticketType->id;
        $ticket->status         = 'awaiting_payment';
        $ticket->price          = $price;
        $ticket->save();

        // Loop over all modfiers and save on ticket
        if ( $ticketModifiers ) {
            foreach ($ticketModifiers as $ticketModifier) {
                $modifier = Modifier::where( [ [ 'ticket_type_id', $ticketTypeID ], [ 'slug', $ticketModifier ] ] )->first();
                $ticket->modifiers()->save($modifier);
            }
        }

        // Save the nin-object with used data.
        if ( $nin_object ) {
            $nin_object->utilized  = true;
            $nin_object->ticket_id = $ticket->id;
            $nin_object->save();
        }

        // Make charge
        $paymentIntent = Stripe::paymentIntents()->create([
            'amount'        => $ticket->price,
            'currency'      => 'sek',
            'receipt_email' => $user->email,
            'description'   => $event->name . ' - ' . $ticketType->name,
            'metadata'      => ['ticket_id' => $ticket->uuid]
        ]);

        // Build and return the ticket array.
		$return_array = array(
			'id'            => $ticket->uuid,
			'eventID'       => $event->id,
            'status'        => $ticket->status,
            'intent_secret' => $paymentIntent['client_secret'],
			'user'          => array(
				'id'            => $user->id,
				'name'          => $user->name,
				'email'         => $user->email,
			),
		);

        // Return ticket to API.
        return $return_array;
    }

    public function ticketsSold( $eventID, $ticketTypeID )
    {
        $tickets     = Ticket::where( [ [ 'event_id', $eventID ], [ 'ticket_type_id', $ticketTypeID ] ])->get();
        $ticketsSold = $tickets->count();

        return $ticketsSold;
    }

    /**
     * Generate a ticket code.
     *
     * @since    1.0.0
     * @access   public
     * @param    int     $length - The length of the ticket code.
     * @return   string
     */
    public function generateTicketCode( int $length = 6 ) {
        $max_random_number = 3000000000 === 2147483647 ? (float) '4294967295' : 4294967295; // 4294967295 = 0xffffffff

        // Create ticket code that is not taken.
        $ticket_code = null;

        while ( null === $ticket_code ) :
            $temp_ticket_code = dechex( rand( $length / 2 + ( $length % 2 > 0 ), $max_random_number ) );

            // Check if taken, if not assign to $uuid.
            $ticket = Ticket::where( 'ticket_code', $temp_ticket_code )->first();
            if ( ! $ticket ) :
                $ticket_code = $temp_ticket_code;
            endif;
        endwhile;

        return $ticket_code;
    }

    /**
    * Generates a unique ID
    *
    * @since    1.0.0
    * @access   public
    * @return   string
    */
    public function genTicketUUID() {
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
