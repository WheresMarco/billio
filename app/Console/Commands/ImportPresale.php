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
    protected $signature = 'billio:import {url}';

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
        // Get file
        $url = $this->argument('url');
        $contents = file_get_contents($url);
        $name = substr($url, strrpos($url, '/') + 1);
        Storage::put($name, $contents);

        Excel::import(new PresaleImport, $name);

        $this->info('Imported!');
    }
}
