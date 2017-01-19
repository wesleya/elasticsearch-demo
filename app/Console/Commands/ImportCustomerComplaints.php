<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ImportCustomerComplaints extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'complaints:import {file : relative patch to csv file from /storage directory}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import customer complaints from CSV to Elasticsearch instance';

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
        $filePath = $this->argument('file');

        $this->info("The file path is: {$filePath}");
    }
}
