<?php
namespace App\Elasticsearch;

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

    public function document($document)
    {
        return $this->client->request(
            'POST',
            "{$this->api}/consumer_complaints/complaint",
            ['auth' => [$this->user, $this->password], 'json' => $document]
        );
    }
}