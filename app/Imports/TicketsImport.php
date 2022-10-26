<?php

namespace App\Imports;

use App\Models\Modifier;
use App\Models\Nin;
use App\Models\Ticket;
use App\Models\TicketType;
use App\Models\User;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TicketsImport implements ToModel, WithHeadingRow
{
    /**
     * @param  array  $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if ($row['email'] == null) {
            return null;
        }

        $email = $row['email'] ?? '';
        $nin = $row['nin'] ?? '';
        $name = $row['name'] ?? '';
        $eventID = (int) $row['event_id'] ?? '';
        $ticketType = $row['ticket_type'] ?? '';
        $ticketModifiers = $row['modifiers'] ? explode(',', $row['modifiers']) : [];
        $status = 'unused';

        if ($eventID == null) {
            return null;
        }

        // CheckStudent
        if ($nin) {
            $ticketModifiers[] = 'union-discount';

            // Add NiN to table and associate with ticket
            $nin_object = Nin::where([['nin', $nin], ['ticket_id', null]])->first();

            if (! $nin_object) {
                $nin_object = new Nin();
                $nin_object->nin = $nin;
                $nin_object->corps = 'import';
                $nin_object->utilized = true;
                $nin_object->save();
            }
        }

        // Check if user exists elese create user
        $user = User::where('email', $email)->first();

        if (! $user) {
            $user = User::create([
                'email' => $email,
                'name' => $name,
                'password' => bcrypt(Str::random(10)),
            ]);
        }

        $ticketType = TicketType::where('slug', $ticketType)->first();

        if (! $ticketType) {
            return null;
        }

        // Get ticket price.
        $price = $ticketType->price;

        $ticket = new Ticket([
            'event_id' => $eventID,
            'user_id' => $user->id,
            'ticket_type_id' => $ticketType->id,
            'price' => $price,
            'status' => $status,
        ]);

        // Save the ticket
        $ticket->save();

        // If nin, add ticket id to nin
        if ($nin) {
            $nin_object->ticket_id = $ticket->id;
            $nin_object->save();
        }

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
