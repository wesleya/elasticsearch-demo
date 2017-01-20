<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Http\Response;

class ApiSearchController extends Controller
{
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

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->elasticsearchApi = env('ELASTICSEARCH_API');
        $this->elasticsearchUser = env('ELASTICSEARCH_USER');
        $this->elasticsearchPassword = env('ELASTICSEARCH_PASSWORD');
    }

    public function index(Request $request)
    {
        switch ($request->input('search_category')) {
            case 'product':
                $response = $this->productSearch(
                    $request->input('search_term'),
                    $request->input('page'),
                    10
                );
                break;
            case 'company':
                $response = $this->companySearch(
                    $request->input('search_term'),
                    $request->input('page'),
                    10
                );
                break;
            case 'issue':
                $response = $this->issueSearch(
                    $request->input('search_term'),
                    $request->input('page'),
                    10
                );
                break;
        }

        $results = json_decode($response->getBody()->getContents())->hits->hits;

        return $results;
    }

    protected function productSearch($search, $page, $limit)
    {
        $terms = [
            [ "term" => [ "product" => $search] ],
            [ "term" => [ "sub_product" => $search] ]
        ];

        return $this->search($terms, $page, $limit);
    }

    protected function companySearch($search, $page, $limit)
    {
        $terms = [
            [ "term" => [ "company" => $search] ]
        ];

        return $this->search($terms, $page, $limit);
    }

    protected function issueSearch($search, $page, $limit)
    {
        $terms = [
            [ "term" => [ "issue" => $search] ],
            [ "term" => [ "sub_issue" => $search] ],
        ];

        return $this->search($terms, $page, $limit);
    }

    protected function search($terms, $page, $limit)
    {
        return $this->client->request('GET', $this->elasticsearchApi . "consumer_complaints/complaint/_search", [
            'auth' => [$this->elasticsearchUser, $this->elasticsearchPassword],
            'json' => [
                "from" => $page,
                "size" => $limit,
                "query" => [
                    "bool" => [
                        "should" => [
                            $terms
                        ]
                    ]
                ]
            ]
        ]);
    }
}
