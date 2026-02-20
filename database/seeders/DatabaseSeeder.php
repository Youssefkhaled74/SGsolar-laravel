<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            \Database\Seeders\RolesSeeder::class,
            \Database\Seeders\SalesUsersSeeder::class,
            \Database\Seeders\AdminUserSeeder::class,
            \Database\Seeders\LeadSourcesSeeder::class,
            \Database\Seeders\LeadStatusesSeeder::class,
            \Database\Seeders\ActionTypesSeeder::class,
            \Database\Seeders\CrmDemoSeeder::class,
            \Database\Seeders\SingleSalesUserSeeder::class,
        ]);
    }
}
