<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class SingleSalesUserSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $salesRole = Role::firstOrCreate(['name' => 'sales']);

            $salesUser = User::updateOrCreate(
                ['email' => 'ommer.galal@sgsolar.local'],
                [
                    'name' => 'Ommer Galal',
                    'phone' => '+20 100 000 0000',
                    'password' => Hash::make('Sales@123'),
                    'role_id' => $salesRole->id,
                    'is_active' => true,
                ]
            );

            $oldSalesIds = User::where('role_id', $salesRole->id)
                ->where('id', '!=', $salesUser->id)
                ->pluck('id')
                ->all();

            // Make this user own all leads for CRM sales visibility.
            if (Schema::hasTable('leads')) {
                DB::table('leads')->update(['assigned_to' => $salesUser->id]);
                DB::table('leads')
                    ->whereIn('created_by', $oldSalesIds)
                    ->update(['created_by' => $salesUser->id]);
            }

            if (! empty($oldSalesIds) && Schema::hasTable('lead_actions')) {
                DB::table('lead_actions')
                    ->whereIn('user_id', $oldSalesIds)
                    ->update(['user_id' => $salesUser->id]);
            }

            if (! empty($oldSalesIds) && Schema::hasTable('lead_comments')) {
                DB::table('lead_comments')
                    ->whereIn('user_id', $oldSalesIds)
                    ->update(['user_id' => $salesUser->id]);
            }

            if (! empty($oldSalesIds) && Schema::hasTable('lead_followups')) {
                DB::table('lead_followups')
                    ->whereIn('assigned_to', $oldSalesIds)
                    ->update(['assigned_to' => $salesUser->id]);

                DB::table('lead_followups')
                    ->whereIn('created_by', $oldSalesIds)
                    ->update(['created_by' => $salesUser->id]);
            }

            // Backward compatibility in case this table exists in older envs.
            if (! empty($oldSalesIds) && Schema::hasTable('lead_follow_ups')) {
                DB::table('lead_follow_ups')
                    ->whereIn('assigned_to', $oldSalesIds)
                    ->update(['assigned_to' => $salesUser->id]);

                DB::table('lead_follow_ups')
                    ->whereIn('created_by', $oldSalesIds)
                    ->update(['created_by' => $salesUser->id]);
            }

            if (! empty($oldSalesIds)) {
                User::whereIn('id', $oldSalesIds)->delete();
            }
        });
    }
}

