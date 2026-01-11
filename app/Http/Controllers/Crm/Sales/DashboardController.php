<?php

namespace App\Http\Controllers\Crm\Sales;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('crm.sales.dashboard');
    }
}
