<?php
namespace App\CustomerComplaints;

use GuzzleHttp\Client;

class Index
{
    /**
     * Guzzle client
     *
     * @var Client
     */
    protected $client;

    /**
     * URL for api endpoint
     *
     * @var string
     */
    protected $api;

    /**
     * Elasticsearch user with write permissions
     *
     * @var string
     */
    protected $user;

    /**
     * Elasticsearch for $user
     *
     * @var string
     */
    protected $password;

    /**
     * @var array
     */
    public static $fields = [
        "date_received",
        "product",
        "sub_product",
        "issue",
        "sub_issue",
        "consumer_complaint_narrative",
        "company_public_response",
        "company",
        "state",
        "zip",
        "tags",
        "consumer_consent_provided",
        "submitted_via",
        "date_sent_to_company",
        "company_response_to_consumer",
        "timely_response",
        "consumer_disputed",
        "complaint_id"
    ];

    /**
     * Elasticsearch constructor.
     *
     * @param Client $client
     * @param string $api
     * @param string $user
     * @param string $password
     */
    public function __construct(Client $client, $api, $user, $password)
    {
        $this->client = $client;
        $this->api = $api;
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * @return Index
     */
    public static  function create()
    {
        $client = new Client();
        $api = env('ELASTICSEARCH_API');
        $user = env('ELASTICSEARCH_USER');
        $password = env('ELASTICSEARCH_PASSWORD');

        return new Index($client, $api, $user, $password);
    }

    /**
     * Index a document into Elasticsearch
     *
     * @param array $document
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function send($document)
    {
        return $this->client->request(
            'POST',
            "{$this->api}/consumer_complaints/complaint_test/",
            ['auth' => [$this->user, $this->password], 'json' => $document]
        );
    }
}