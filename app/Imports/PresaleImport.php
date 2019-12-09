<?php

namespace App\Imports;

use App\Ticket;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\CheckStudentController;

class PresaleImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $accessCode      = '';
        $email           = (string) $row[0];
        $nin             = $row[1] ? (string) $row[1] : '';
        $firstName       = (string) $row[2];
        $lastName        = '';
        $eventID         = (string) $row[3];
        $ticketTypeID    = (string) $row[4];
        $ticketModifiers = $row[5] ? explode(',', $row[5]) : [];
        $ninValid        = true;

        // CheckStudent
        if ($nin) {
            $checkStudent      = new CheckStudentController;
            $ninResult = $checkStudent->isStudentMember( $nin );

            if ('false' !== $ninResult) {
                $ticketModifiers[] = $checkStudent->isStudentMember( $nin );
            } else {
                $ninValid = false;
                var_dump('Nin not valid: ' . $nin);
            }
        }

        // https://nutopia.se/presale.xlsx
        $ticketModifiers = array_filter($ticketModifiers);
        var_dump($ticketModifiers);

        $ticket = ( new TicketController() )->createTicket($accessCode, $email, $nin, $firstName, $lastName, $eventID, $ticketTypeID, $ticketModifiers);

        if ($ninValid) {
            event(new \App\Events\TicketPurchased($ticket));
        }

        var_dump('Imported: ' . $ticket->id);

        return $ticket;
    }
}
