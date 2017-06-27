<?php

namespace App\Http\Controllers;

use App\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiSearchController extends Controller
{
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

        return  Complaint::select('product',
                'sub_product',
                'issue',
                'sub_issue',
                'complaint_what_happened',
                'company_public_response',
                'company',
                'company_response'
            )
            ->addSelect(DB::raw('DATE(date_received) as date_received'))
            ->where('company', 'like', "%{$term}%")
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
