<?php

namespace App\Http\Controllers;

class ServicesController extends Controller
{
    public function index()
    {
        return view('pages.services', [
            'data' => config('website')
        ]);
    }
}
