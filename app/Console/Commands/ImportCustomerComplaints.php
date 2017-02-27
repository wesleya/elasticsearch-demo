<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Keboola\Csv;
use GuzzleHttp\Client;
use DateTime;

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
    protected $description = 'Import customer complaints from CSV to Elasticsearch instance';

    /**
     * Guzzle client
     *
     * @var Client
     */
    protected $client;

    /**
     * Elasticsearch api uri
     *
     * @var string
     */
    protected $elasticsearchApi;

    /**
     * Elasticsearch user
     *
     * @var string
     */
    protected $elasticsearchUser;

    /**
     * Elasticsearch password
     *
     * @var string
     */
    protected $elasticsearchPassword;

    /**
     * Create a new command instance.
     *
     * @param Client $client
     * @return void
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->elasticsearchApi = env('ELASTICSEARCH_API');
        $this->elasticsearchUser = env('ELASTICSEARCH_USER');
        $this->elasticsearchPassword = env('ELASTICSEARCH_PASSWORD');

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

        if(!file_exists($filePath)) {
            $this->error("File does not exist: {$filePath}");
            return;
        }

        $csvFile = new Csv\CsvFile($filePath);
        $count = 0;

        foreach($csvFile as $row) {
            $this->log($row, $count);

            try {
                $this->index($row, $count, $production);
            } catch (\Exception $e) {
                echo $e->getMessage();
            }

            $count++;
            usleep($throttle);
        }
    }

    /**
     * Index document to elasticsearch
     *
     * @param $row
     * @param $count
     * @param $production
     */
    protected function index($row, $count, $production)
    {
        if($count == 0) {
            return;
        }

        if(!$production) {
            return;
        }

        $response = $this->client->request('POST', $this->elasticsearchApi . "consumer_complaints/complaint", [
            'auth' => [$this->elasticsearchUser, $this->elasticsearchPassword],
            'json' => [
                "date_received" => DateTime::createFromFormat('m/d/Y', $row[0])->format('Y-m-d'),
                "product" => $row[1],
                "sub_product" => $row[2],
                "issue" => $row[3],
                "sub_issue" => $row[4],
                "consumer_complaint_narrative" => $row[5],
                "company_public_response" => $row[6],
                "company" => $row[7],
                "state" => $row[8],
                "zip" => $row[9],
                "tags" => $row[10],
                "consumer_consent_provided" => $row[11],
                "submitted_via" => $row[12],
                "date_sent_to_company" => DateTime::createFromFormat('m/d/Y', $row[13])->format('Y-m-d'),
                "company_response_to_consumer" => $row[14],
                "timely_response" => $row[15],
                "consumer_disputed" => $row[16],
                "complaint_id" => $row[17]
            ]
        ]);
    }

    /**
     * log debug output to console
     *
     * @param $row
     * @param $count
     */
    protected function log($row, $count)
    {
        echo "{$count}. ";
        echo "date_received: {$row[0]} ";
        echo "product: {$row[1]} ";
        echo "sub_product: {$row[2]} ";
        echo "issue: {$row[3]} ";
        echo "sub_issue: {$row[4]} ";
        echo "consumer_complaint_narrative: {$row[5]} ";
        echo "company_public_response: {$row[6]} ";
        echo "company: {$row[7]} ";
        echo "state: {$row[8]} ";
        echo "zip: {$row[9]} ";
        echo "tags: {$row[10]} ";
        echo "consumer_consent_provided: {$row[11]} ";
        echo "submitted_via: {$row[12]} ";
        echo "date_sent_to_company: {$row[13]} ";
        echo "company_response_to_consumer: {$row[14]} ";
        echo "timely_response: {$row[15]} ";
        echo "consumer_disputed: {$row[16]} ";
        echo "complaint_id: {$row[17]} \n";
    }
}
