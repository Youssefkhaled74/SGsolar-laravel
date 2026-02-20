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
        // Normalize admin role to avoid access issues caused by case/spacing differences.
        $role = Role::query()
            ->whereRaw('LOWER(TRIM(name)) = ?', ['admin'])
            ->first();

        if (! $role) {
            $role = Role::create(['name' => 'admin']);
        } elseif ($role->name !== 'admin') {
            $role->name = 'admin';
            $role->save();
        }

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
