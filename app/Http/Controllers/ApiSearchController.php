<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

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
    protected $elasticApi;

    /**
     * Elasticsearch user
     *
     * @var string
     */
    protected $elasticUser;

    /**
     * Elasticsearch password
     *
     * @var string
     */
    protected $elasticPassword;

    /**
     * ApiSearchController constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->elasticApi = env('ELASTICSEARCH_API');
        $this->elasticUser = env('ELASTICSEARCH_USER');
        $this->elasticPassword = env('ELASTICSEARCH_PASSWORD');
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function index(Request $request)
    {
        switch ($request->input('search_category')) {
            case 'product':
                $response = $this->productSearch($request);
                break;
            case 'company':
                $response = $this->companySearch($request);
                break;
            case 'issue':
                $response = $this->issueSearch($request);
                break;
            default:
                $response = $this->globalSearch($request);
        }

        $results = json_decode($response->getBody()->getContents())->hits->hits;

        return $results;
    }

    /**
     * @param Request $request
     * @return \GuzzleHttp\Psr7\Response
     */
    public function globalSearch(Request $request)
    {
        $terms = [
            [ "term" => [ "product" => $request->input('search_term')] ],
            [ "term" => [ "sub_product" => $request->input('search_term')] ],
            [ "term" => [ "company" => $request->input('search_term')] ],
            [ "term" => [ "issue" => $request->input('search_term')] ],
            [ "term" => [ "sub_issue" => $request->input('search_term')] ]
        ];

        return $this->search(
            $terms,
            $request->input('page'),
            $request->input('limit')
        );
    }

    /**
     * Run a product query against elasticsearch
     *
     * @param Request $request
     * @return \GuzzleHttp\Psr7\Response
     */
    protected function productSearch(Request $request)
    {
        $terms = [
            [ "term" => [ "product" => $request->input('search_term')] ],
            [ "term" => [ "sub_product" => $request->input('search_term')] ]
        ];

        return $this->search(
            $terms,
            $request->input('page'),
            $request->input('limit')
        );
    }

    /**
     * Run a company search against elasticsearch
     *
     * @param Request $request
     * @return \GuzzleHttp\Psr7\Response
     */
    protected function companySearch(Request $request)
    {
        $terms = [
            [ "term" => [ "company" => $request->input('search_term')] ]
        ];

        return $this->search(
            $terms,
            $request->input('page'),
            $request->input('limit')
        );
    }

    /**
     * Run an issue search against elasticsearch
     *
     * @param Request $request
     * @return \GuzzleHttp\Psr7\Response
     */
    protected function issueSearch(Request $request)
    {
        $terms = [
            [ "term" => [ "issue" => $request->input('search_term')] ],
            [ "term" => [ "sub_issue" => $request->input('search_term')] ],
        ];

        return $this->search(
            $terms,
            $request->input('page'),
            $request->input('limit')
        );
    }

    /**
     * Make api call to elastic search
     *
     * @param array $terms
     * @param int $page
     * @param int $limit
     * @return \GuzzleHttp\Psr7\Response
     */
    protected function search($terms, $page, $limit)
    {
        return $this->client->request('GET', "{$this->elasticApi}/consumer_complaints/complaint/_search", [
            'auth' => [$this->elasticUser, $this->elasticPassword],
            'json' => [
                "from" => $page,
                "size" => $limit,
                "query" => [
                    "bool" => [
                        "should" => [$terms]
                    ]
                ]
            ]
        ]);
    }
}
