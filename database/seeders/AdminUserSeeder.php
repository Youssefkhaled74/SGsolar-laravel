<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        $role = Role::firstWhere('name', 'admin');

        $adminData = [
            'name' => 'Admin',
            'email' => 'admin@sgsolar.com',
            'phone' => null,
            'password' => Hash::make('Admin@123'),
            'role_id' => $role ? $role->id : null,
            'is_active' => true,
        ];

        User::updateOrCreate(
            ['email' => $adminData['email']],
            $adminData
        );
    }
}
