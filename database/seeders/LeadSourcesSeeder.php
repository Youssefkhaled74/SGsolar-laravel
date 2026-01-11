<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LeadSource;
use Illuminate\Support\Str;

class LeadSourcesSeeder extends Seeder
{
    public function run()
    {
        $sources = [
            'Contact Us',
            'Product Page',
            'Manual',
            'Excel Import',
        ];

        foreach ($sources as $name) {
            LeadSource::updateOrCreate(
                ['name' => $name],
                [
                    'external_key' => Str::slug($name),
                    'description' => null,
                ]
            );
        }
    }
}
