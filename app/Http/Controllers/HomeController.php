<?php
namespace App\Http\Controllers;

use App\Complaint;
use Illuminate\Support\Facades\DB;

class HomeController
{
    public function index()
    {
        return view('home/index');
    }
}