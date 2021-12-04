<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Modifier;
use App\Models\Ticket;
use App\Models\TicketType;
use App\Models\Nin;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Http\Controllers\CheckStudentController;
use Illuminate\Support\Str;

class TicketsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if ($row['tidstampel'] == null) {
            return null;
        };

        $email           = $row['e_postadress'] ?? '';
        $nin             = $row['personnummer_ifylles_endast_for_karrabatt'] ?? '';
        $name            = $row['fullstandigt_namn'] ?? '';
        $eventID         = (int) $row['billio_id'] ?? '';
        $ticketType      = $row['biljettyp_obs_sittning_inkluderar_fest'] ?? '';
        $ticketModifiers = [];
        $paid            = $row['betalat'] ?? '';
        $billio_status   = $row['billio_status'] ?? '';
        $status          = 'unused';

        // If Billio status is not empty the ticket is already imported
        if ($billio_status != '') {
            return null;
        }

        if ($eventID == null) {
            return null;
        }

        // If ticket is not paid return null
        if ($paid != 'JA') {
            return null;
        }

        // CheckStudent
        if ($nin) {
            $ticketModifiers[] = 'union-discount';

            // Add NiN to table and associate with ticket
            $nin_object = Nin::where([ [ 'nin', $nin ], [ 'ticket_id', null ] ])->first();

            if (! $nin_object) {
                $nin_object           = new Nin();
                $nin_object->nin      = $nin;
                $nin_object->corps    = 'import';
                $nin_object->utilized = true;
                $nin_object->save();
            }
        }

        // If $row['vill_du_ha_marke_ingar_i_sittningsbiljett'] is not empty, add 'path' to ticketModifiers
        if ($row['vill_du_ha_marke_ingar_i_sittningsbiljett'] == 'Ja') {
            $ticketModifiers[] = 'path';
        }

        // Switch on $row['dryck_till_sittningen]
        switch ($row['dryck_till_sittningen']) {
            case 'Julöl':
                $ticketModifiers[] = 'beer';
                break;
            case 'Julöl (alkoholfri)':
                $ticketModifiers[] = 'beer-no-alcohol';
                break;
            case 'Julmust':
                $ticketModifiers[] = 'must';
                break;
            default:
                break;
        }

        // TODO Add kostval

        // Check if user exists elese create user
        $user = User::where('email', $email)->first();

        if (!$user) {
            $user = User::create([
                'email'    => $email,
                'name'     => $name,
                'password' => bcrypt(Str::random(10))
            ]);
        }

        // Get ticket type based on ticketType
        switch ($ticketType) {
            case 'Sittning':
                $ticketType = TicketType::where('slug', 'dinner')->first();
                break;
            default:
                $ticketType = TicketType::where('slug', 'party')->first();
                break;
        }

        // Get ticket price.
        $price = $ticketType->price;

        $ticket = new Ticket([
            'event_id'       => $eventID,
            'user_id'        => $user->id,
            'ticket_type_id' => $ticketType->id,
            'price'          => $price,
            'status'         => $status,
        ]);

        // Save the ticket
        $ticket->save();

        // Remove duplicates and empty values
        $ticketModifiers = array_filter($ticketModifiers);

        // Loop over all modfiers and save on ticket
        if ($ticketModifiers) {
            foreach ($ticketModifiers as $ticketModifier) {
                $modifier = Modifier::where([['ticket_type_id', $ticketType->id], ['slug', $ticketModifier]])->first();
                if ($modifier) {
                    $ticket->modifiers()->save($modifier);
                    $ticket->price = $price + $modifier->delta;
                }
            }
        }

        // Resave the ticket
        $ticket->save();

        // Finilize the ticket.
        event(new \App\Events\TicketPurchased($ticket));

        return $ticket;
    }
}
