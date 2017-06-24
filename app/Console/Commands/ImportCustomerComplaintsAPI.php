<?php

namespace App\Console\Commands;

use App\Complaint;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use DateTime;

/**
 * Class ImportCustomerComplaints
 *
 * example: '/home/forge/Consumer_Complaints.csv' > ~/import-log-2017-02-27.log 2>&1
 *
 * @package App\Console\Commands
 */
class ImportCustomerComplaintsAPI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import-complaints:api
        {--throttle=200000 : microseconds to throttle between each document. default 300000.}
        {--limit=100 : max number of records to import. default 100.}
        {--production} : send data to elasticsearch instance. dry run otherwise.
        ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import customer complaints from API to Database. example: php artisan import-complaints:api';

    /**
     * @var Client
     */
    protected $client;

    public function __construct()
    {
        parent::__construct();

        $this->client = new Client();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $count = 0;
        $complaints = $this->getComplaints();
        $continue = count($complaints);

        while($continue)
        {
            foreach($complaints as $complaint) {
                try {
                    $complaint = $this->formatComplaint($complaint);
                    $this->create($complaint);
                } catch (\Exception $e) {
                    $this->error($e->getMessage());
                }

                $count++;

                if($count >= (int)$this->option('limit')) {
                    $continue = false;
                    break;
                }

                usleep($this->option('throttle'));
            }

            $this->info($count);
            $complaints = $this->getComplaints();
        }
    }

    protected function getComplaints()
    {
        $lastComplaintId = Complaint::max('complaint_id');

        $query = [
            '$limit' => '10',
            '$order' => 'complaint_id ASC'
        ];

        if($lastComplaintId) {
            $query['$where'] = "complaint_id>{$lastComplaintId}";
        }

        $res = $this->client->request('GET', 'https://data.consumerfinance.gov/resource/jhzv-w97w.json', [
            'headers' => ['X-App-Token' => 'wVqw2fpuDbgdCDKEbDCRt406J'],
            'query' => $query
        ]);

        return json_decode($res->getBody()->getContents());
    }

    /**
     * Index a document into Elasticsearch
     *
     * @param array $complaint
     * @return Complaint;
     */
    protected function create($complaint)
    {
        if(!$this->option('production')) {
            return $this->info(json_decode($complaint));
        }

        return Complaint::create($complaint);
    }

    /**
     * Format csv data into format Elasticsearch can understand
     *
     * @param array $complaint
     * @return array
     */
    protected function formatComplaint($complaint)
    {
        $complaint = (array)$complaint;

        $complaint['date_received'] = DateTime::createFromFormat('Y-m-d\TH:i:s.000', $complaint['date_received'])
            ->format('Y-m-d');

        $complaint['date_sent_to_company'] = DateTime::createFromFormat('Y-m-d\TH:i:s.000', $complaint['date_sent_to_company'])
            ->format('Y-m-d');

        return $complaint;
    }
}
