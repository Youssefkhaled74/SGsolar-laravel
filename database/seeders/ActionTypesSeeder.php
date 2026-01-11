<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ActionType;
use Illuminate\Support\Str;

class ActionTypesSeeder extends Seeder
{
    public function run()
    {
        $types = [
            'Call',
            'WhatsApp',
            'Meeting',
            'Follow Up',
        ];

        foreach ($types as $name) {
            ActionType::updateOrCreate(
                ['name' => $name],
                [
                    'key' => Str::slug($name),
                    'description' => null,
                    'default_duration_minutes' => null,
                ]
            );
        }
    }
}
