<?php

namespace App\Http\Controllers;

use App\Complaint;
use App\CustomerComplaints\Search;
use Illuminate\Http\Request;

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
        $offset = empty($page) ? 0 : ($page + 1) * $limit;

        return  Complaint::where('company', 'like', "%{$term}%")
            ->offset($offset)
            ->take($limit)
            ->orderByRaw('complaint_what_happened IS NOT NULL DESC')
            ->orderBy('date_received', 'DESC')
            ->get();
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
