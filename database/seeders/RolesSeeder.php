<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesSeeder extends Seeder
{
    public function run()
    {
        $roles = ['admin', 'sales'];

        foreach ($roles as $name) {
            Role::updateOrCreate(
                ['name' => $name],
                ['name' => $name]
            );
        }
    }
}
