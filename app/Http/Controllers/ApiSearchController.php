<?php

namespace App\Http\Controllers;

use App\CustomerComplaints\Search;
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
     * ApiSearchController constructor.
     */
    public function __construct()
    {
        $this->search = Search::create();
    }

    /**
     * @param Request $request
     * @return \GuzzleHttp\Psr7\Response
     */
    public function index(Request $request)
    {
        $this->validate($request, $this->rules());

        $term = $request->input('search_term');
        $page = $request->input('page');
        $limit = $request->input('limit');

        return $this->search->general($term, $page, $limit);
    }

    /**
     * Get validation rules
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'search_term' => 'required',
            'page' => ['required', 'integer'],
            'limit' => ['required', 'integer']
        ];
    }

}
