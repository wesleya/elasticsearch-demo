<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Complaint;
use Illuminate\Support\Facades\DB;

class ListController extends Controller
{
    public function index()
    {
        $companies = Complaint::select('company',  DB::raw('COUNT(*) as count'))
            ->groupBy('company')
            ->take(10)
            ->orderByRaw('COUNT(*) DESC')
            ->get();

        return view('list/index', ['companies' => $companies]);
    }
}
