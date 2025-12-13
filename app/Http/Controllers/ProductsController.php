<?php

namespace App\Http\Controllers;

class ProductsController extends Controller
{
    public function index()
    {
        return view('pages.products', [
            'data' => config('website')
        ]);
    }

    public function swh()
    {
        return view('pages.products-swh');
    }

    public function lights()
    {
        return view('pages.products-lights');
    }

    public function panels()
    {
        return view('pages.products-panels');
    }
}
