<?php

namespace App\Http\Controllers\Crm\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('crm.admin.dashboard');
    }
}
