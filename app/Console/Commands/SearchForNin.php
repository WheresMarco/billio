<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\CheckStudentController;

class SearchForNin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'billio:search-for-nin {nin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Search Kårerna for NiN and return if valid.';

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
        ray((new CheckStudentController())->isStudentMember($this->argument('nin')));
        return 'test';
    }
}
