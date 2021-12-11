<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class GetUsersWithNoTickets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'billio:get-users-with-no-tickets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Returns users with no tickets';

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
     * @return int
     */
    public function handle()
    {
        // Get users with no tickets
        $users = User::whereDoesntHave('tickets')->get();

        $this->info('Users with no tickets:');

        // Display users
        foreach ($users as $user) {
            $this->info("$user->name ($user->email)");
        }

        return Command::SUCCESS;
    }
}
