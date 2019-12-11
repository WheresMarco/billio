<?php

namespace App\Console\Commands;

use App\Imports\PresaleImport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Revolution\Google\Sheets\Facades\Sheets;

use App\Ticket;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\CheckStudentController;

class ImportPresale extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'billio:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports tickets from CSV';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $sheets = Sheets::spreadsheet('1OAXRiWyFbDOa-LbVwiQeSwCHaIfXg5Ml5m-sbFPh4p4')
        ->sheet('Data')
        ->get();

        $header = $sheets->pull(0);
        $posts = Sheets::collection($header, $sheets);
        $posts = $posts->toArray();

        if ($posts) {
            foreach ($posts as $post) {
                $ticketModifiers = [];
                $ticketModifiers = explode(',', $post['modifiers']);
                $valid = true;

                if ('Betalat' !== $post['paid']) {
                    $this->error('Ticket not paid: ' . $post['email']);
                    continue;
                }

                // CheckStudent
                if ('' !== $post['nin']) {
                    $checkStudent = new CheckStudentController;
                    $ninResult = $checkStudent->isStudentMember( $post['nin'] );

                    if ('false' === $ninResult) {
                        $valid = false;
                        $this->error('Nin not valid: ' . $post['nin']);
                    }
                }

                $ticketModifiers = array_filter($ticketModifiers);

                $ticket = ( new TicketController() )->createTicket('', $post['email'], $post['nin'], $post['name'], '', $post['event_id'], $post['ticket_type_id'], $ticketModifiers);

                if (!$ticket) {
                    $this->error('Ticket not created: ' . $post['email']);
                    continue;
                }

                if ($valid) {
                    event(new \App\Events\TicketPurchased($ticket));
                }

                $this->info('Imported: ' . $post['email'] . ' - ' . $ticket->id);
            }
        }

        $this->info('All imported!');
    }
}
