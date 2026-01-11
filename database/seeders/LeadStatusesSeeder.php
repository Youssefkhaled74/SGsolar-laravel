<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LeadStatus;

class LeadStatusesSeeder extends Seeder
{
    public function run()
    {
        $statuses = [
            ['name' => 'New', 'sort_order' => 10, 'is_default' => true],
            ['name' => 'In Progress', 'sort_order' => 20, 'is_default' => false],
            ['name' => 'Closed', 'sort_order' => 90, 'is_default' => false],
        ];

        foreach ($statuses as $s) {
            LeadStatus::updateOrCreate(
                ['name' => $s['name']],
                [
                    'sort_order' => $s['sort_order'],
                    'is_default' => $s['is_default'],
                    'color' => null,
                ]
            );
        }
    }
}
