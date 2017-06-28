<?php
namespace App\Http\Controllers;

use App\Complaint;
use Illuminate\Support\Facades\DB;

class HomeController
{
    public function index()
    {
        $companies = Complaint::select('company',  DB::raw('COUNT(*)'))
            ->groupBy('company')
            ->take(5)
            ->orderByRaw('COUNT(*) DESC')
            ->get();

        $companies = $companies->map(function ($company, $key) {
            $company->complaint_what_happened = $this->getComplaint($company->company);
            return $company;
        });

        return view('welcome');
    }

    protected function getComplaint($company)
    {
        return Complaint::select('complaint_what_happened')
            ->whereNotNull('what_happened_count')
            ->where('company', $company)
            ->orderBy('date_received', 'DESC')
            ->value('what_happened_count');
    }
}