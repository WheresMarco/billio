<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;

class EventController extends Controller
{
    public function single($eventSlug)
    {
        if (!$event = Event::where('slug', $eventSlug)->first()) {
            return redirect('/');
        }

        // Get all the ticks for this event and then get the modifiers for each ticket where the modifier_type is 'donation'
        $ticketModifiers = Ticket::where('event_id', $event->id)->where('status', 'unused')->orWhere('status', 'used')->with(['modifiers' => function ($query) {
            $query->where('modifier_type', 'donation');
        }])->get()->pluck('modifiers')->flatten();

        // Get all the donations for this event where status is not 'awaiting_payment'
        $donations = $event->donations()->where('status', '!=', 'awaiting_payment')->get();

        // Create a new collection of all the modifiers and donations
        $donations = $ticketModifiers->merge($donations);

        // Map out the donations to a new array with the name and amount
        $donations = $donations->map(function ($donation) {
            // If the donation is a ticket modifier, get the delta for the amount
            if ($donation->modifier_type == 'donation') {
                $donation->amount = $donation->delta;
            }

            return [
                'amount' => $donation->amount,
            ];
        });

        // Sum the donations
        $donations_amount = $donations->sum('amount');

        // Loop out description and get only donation tab
        $donation_goals = null;
        $description = $event->getDescription();
        foreach ($description as $tab) {
            if ($tab->name() == 'donations') {
                $donation_goals = $tab->goals;
            }
        }

        // Get the next donation goal
        $next_donation_goal = null;
        if ($donation_goals) {
            foreach ($donation_goals as $donation_goal_key => $donation_goal) {
                if ($donations_amount < $donation_goal->amount) {
                    $next_donation_goal = $donation_goal;
                    $next_donation_goal->key = $donation_goal_key;
                    break;
                }
            }
        }

        // Get the procentage of current goal reached
        if ($next_donation_goal) {
            $next_donation_goal->percentage = round(($donations_amount / $next_donation_goal->amount) * 100);
        }

        return view('event.single', [
            'event' => $event,
            'donations_amount' => $donations_amount,
            'donation_goals' => $donation_goals,
            'next_donation_goal' => $next_donation_goal,
        ]);
    }
}
