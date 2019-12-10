<?php

namespace App\Console\Commands;

use App\Imports\PresaleImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

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
        Excel::import(new PresaleImport, Storage::disk('s3')->url('presale.xlsx'));

        $this->info('Imported!');
    }
}
