<?php

namespace App\Http\Controllers;

use App\Elasticsearch\Search;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ApiSearchController extends Controller
{
    /**
     * Elasticsearch search helper
     *
     * @var Search
     */
    protected $search;

    /**
     * Valid search types
     *
     * @var array
     */
    protected static $searchTypes = [
        'product',
        'company',
        'issue',
        'general'
    ];

    /**
     * ApiSearchController constructor.
     */
    public function __construct()
    {
        $this->search = Search::create();
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function index(Request $request)
    {
        $this->validate($request, $this->rules());

        $method = $request->input('search_method');
        $term = $request->input('search_term');
        $page = $request->input('page');
        $limit = $request->input('limit');

        return $this->search->$method($term, $page, $limit);
    }

    /**
     * Get validation rules
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'search_method' => [
                'required',
                Rule::in(self::$searchTypes),
            ],
            'search_term' => 'required',
            'page' => ['required', 'integer'],
            'limit' => ['required', 'integer']
        ];
    }

}
