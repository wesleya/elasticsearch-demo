<?php
namespace App\CustomerComplaints;

use GuzzleHttp\Client;

class Search
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
     * Elasticsearch user with at least read permissions
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
     * @return Search
     */
    public static  function create()
    {
        $client = new Client();
        $api = env('ELASTICSEARCH_API');
        $user = env('ELASTICSEARCH_USER');
        $password = env('ELASTICSEARCH_PASSWORD');

        return new Search($client, $api, $user, $password);
    }

    /**
     * Search by general (global search)
     *
     * @param string $term the search term
     * @param int $page
     * @param int $limit
     * @return \GuzzleHttp\Psr7\Response
     */
    public function general($term, $page, $limit)
    {
        $query = [
            $this->match('product', $term),
            $this->match('sub_product', $term),
            $this->match('company', $term),
            $this->match('issue', $term),
            $this->match('sub_issue', $term)
        ];

        return $this->search($query, $page, $limit);
    }

    /**
     * Make api call to elastic search
     *
     * @param array $query
     * @param int $page
     * @param int $limit
     * @return \GuzzleHttp\Psr7\Response
     */
    protected function search($query, $page, $limit)
    {
        $response = $this->client->request('GET', "{$this->api}/consumer_complaints/complaint/_search", [
            'auth' => [$this->user, $this->password],
            'json' => [
                "from" => $page,
                "size" => $limit,
                "query" => [
                    "bool" => [
                        "should" => [$query]
                    ]
                ],
                "highlight" => [
                    "fields" => [
                        "issue" => new \stdClass(),
                        "sub_issue" => new \stdClass(),
                        "product" => new \stdClass(),
                        "sub_product" => new \stdClass(),
                        "company" => new \stdClass()
                    ],
                    'require_field_match' => false
                ]
            ]
        ]);

        return json_decode($response->getBody()->getContents())->hits->hits;
    }

    protected function match($field, $value)
    {
        return [
            "match" => [
                $field => [
                    "query" => $value,
                    "analyzer" => "standard"
                ]
            ]
        ];
    }
}