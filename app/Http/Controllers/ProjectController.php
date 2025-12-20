<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProjectController extends Controller
{
    public function index()
    {
        $portfolioPath = public_path('our porfolio');
        $projects = [];

        if (File::exists($portfolioPath)) {
            $folders = File::directories($portfolioPath);

            foreach ($folders as $folder) {
                $folderName = basename($folder);
                $images = [];

                // Get all image files from the folder
                $files = File::files($folder);
                foreach ($files as $file) {
                    $extension = strtolower($file->getExtension());
                    if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                        $images[] = 'our porfolio/' . $folderName . '/' . $file->getFilename();
                    }
                }

                if (!empty($images)) {
                    $projects[] = [
                        'name' => $folderName,
                        'images' => $images,
                        'slug' => str_replace(' ', '-', $folderName)
                    ];
                }
            }
        }

        return view('pages.projects', compact('projects'));
    }
}
