<?php
namespace App\Http\Controllers;

use App\Complaint;
use Illuminate\Support\Facades\DB;

class HomeController
{
    public function index()
    {
        $companies = Complaint::select('company',  DB::raw('COUNT(*) as count'))
            ->groupBy('company')
            ->take(5)
            ->orderByRaw('COUNT(*) DESC')
            ->get();

        return view('welcome', ['companies' => $companies]);
    }
}