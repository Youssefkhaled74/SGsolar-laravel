<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class SalesUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $salesRole = Role::firstWhere('name', 'sales');

        $users = [
            ['name' => 'Ahmed Ali', 'email' => 'ahmed.ali@sgsolar.local', 'phone' => '+20 100 200 3001'],
            ['name' => 'Mohamed Hassan', 'email' => 'mohamed.hassan@sgsolar.local', 'phone' => '+20 100 200 3002'],
            ['name' => 'Sara Mostafa', 'email' => 'sara.mostafa@sgsolar.local', 'phone' => '+20 100 200 3003'],
            ['name' => 'Youssef Ibrahim', 'email' => 'youssef.ibrahim@sgsolar.local', 'phone' => '+20 100 200 3004'],
            ['name' => 'Mona Ahmed', 'email' => 'mona.ahmed@sgsolar.local', 'phone' => '+20 100 200 3005'],
        ];

        foreach ($users as $u) {
            User::updateOrCreate([
                'email' => $u['email'],
            ], [
                'name' => $u['name'],
                'email' => $u['email'],
                'phone' => $u['phone'],
                'password' => Hash::make('Sales@123'),
                'role_id' => $salesRole ? $salesRole->id : null,
                'is_active' => true,
            ]);
        }
    }
}
