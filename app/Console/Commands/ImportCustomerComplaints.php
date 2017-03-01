<?php

namespace App\Console\Commands;

use App\CustomerComplaints\Index;
use Illuminate\Console\Command;
use League\Csv;
use DateTime;

/**
 * Class ImportCustomerComplaints
 *
 * example: '/home/forge/Consumer_Complaints.csv' > ~/import-log-2017-02-27.log 2>&1
 *
 * @package App\Console\Commands
 */
class ImportCustomerComplaints extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'complaints:import {file : relative patch to csv file from /storage directory}
                                              {--throttle=300000 : microseconds to throttle between each document. default 300000.}  
                                              {--production} : send data to elasticsearch instance. dry run otherwise.';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import customer complaints from CSV to Elasticsearch instance. example: php artisan complaints:import';

    /**
     * @var Index
     */
    protected $index;

    /**
     * Create a new command instance.
     *
     * @param Client $client
     * @return void
     */
    public function __construct()
    {
        $this->index = Index::create();

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
        $throttle = $this->option('throttle');
        $production = $this->option('production');

        $reader = Csv\Reader::createFromPath($filePath);
        $csv = $reader->fetch();

        foreach($csv as $row) {
            // skip header
            if($csv->key() == 0) {
                continue;
            }

            try {
                $this->log($row, $csv->key());
                $this->index($row, $production);
            } catch (\Exception $e) {
                $this->error($e->getMessage());
            }

            usleep($throttle);
        }
    }

    protected function index($row, $production)
    {
        if(!$production) {
            return;
        }

        $this->index->send($this->formatRow($row));
    }

    protected function log($row, $key)
    {
        $this->info("{$key}: " . implode(",", $row));
    }

    protected function formatRow($row)
    {
        $row = array_combine(Index::$fields, $row);

        $row['date_received'] = DateTime::createFromFormat('m/d/Y', $row['date_received'])
            ->format('Y-m-d');

        $row['date_sent_to_company'] = DateTime::createFromFormat('m/d/Y', $row['date_sent_to_company'])
            ->format('Y-m-d');


        return $row;
    }
}
