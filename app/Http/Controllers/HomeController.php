<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        // Get all projects and select 3 random ones
        $allProjects = ProjectController::getAllProjects();
        $randomProjects = [];
        
        if (count($allProjects) > 0) {
            shuffle($allProjects);
            $randomProjects = array_slice($allProjects, 0, min(3, count($allProjects)));
        }
        
        return view('pages.home', [
            'data' => config('website'),
            'portfolioProjects' => $randomProjects
        ]);
    }
}
