<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Models\Lead;
use App\Models\LeadSource;
use App\Models\LeadStatus;
use App\Models\ActionType;
use App\Models\LeadComment;
use App\Models\LeadAction;
use App\Models\LeadFollowUp;
use App\Models\User;
use App\Models\Role;

class CrmDemoSeeder extends Seeder
{
    public function run()
    {
        // Ensure base reference data exists (idempotent)
        $sources = [
            'Contact Us',
            'Product Page',
            'Manual',
            'Excel Import',
        ];

        foreach ($sources as $s) {
            LeadSource::updateOrCreate(['name' => $s], [
                'external_key' => Str::slug($s),
                'description' => null,
            ]);
        }

        $statuses = [
            ['name' => 'New', 'sort_order' => 10, 'is_default' => true],
            ['name' => 'In Progress', 'sort_order' => 20, 'is_default' => false],
            ['name' => 'Closed', 'sort_order' => 90, 'is_default' => false],
        ];

        foreach ($statuses as $st) {
            LeadStatus::updateOrCreate(['name' => $st['name']], [
                'sort_order' => $st['sort_order'],
                'is_default' => $st['is_default'],
                'color' => null,
            ]);
        }

        $actionTypes = ['Call', 'WhatsApp', 'Meeting', 'Follow Up'];
        foreach ($actionTypes as $t) {
            ActionType::updateOrCreate(['name' => $t], [
                'key' => Str::slug($t),
                'description' => null,
                'default_duration_minutes' => null,
            ]);
        }

        // Ensure there's a sales user
        $salesRole = Role::firstWhere('name', 'sales');
        $adminUser = User::firstWhere('email', 'admin@sgsolar.com');

        $salesUser = User::firstWhere('email', 'sales@sgsolar.local');
        if (! $salesUser) {
            $salesUser = User::create([
                'name' => 'Sales User',
                'email' => 'sales@sgsolar.local',
                'phone' => '+20 100 000 0000',
                'password' => Hash::make('Sales@123'),
                'role_id' => $salesRole ? $salesRole->id : null,
                'is_active' => true,
            ]);
        }

        // Sample leads (deterministic)
        $demoLeads = [
            ['name'=>'John Doe','phone'=>'+1 555-1234','email'=>'john@example.com','message'=>'Interested in 5kW system','product_text'=>'5kW Solar Panel Kit','source'=>'Contact Us','status'=>'New','assigned'=>null],
            ['name'=>'Jane Smith','phone'=>'+1 555-9876','email'=>'jane@example.com','message'=>'Requesting quote','product_text'=>'Solar Light Set','source'=>'Product Page','status'=>'In Progress','assigned'=>$salesUser->id],
            ['name'=>'Amir Khaled','phone'=>'+20 100 123 4567','email'=>'amir@example.com','message'=>'Need installation details','product_text'=>'SWH 200L','source'=>'Manual','status'=>'New','assigned'=>null],
            ['name'=>'Sara Ali','phone'=>'+20 101 555 1234','email'=>'sara@example.com','message'=>'Follow up on demo','product_text'=>'Solar Panel 3kW','source'=>'Excel Import','status'=>'Closed','assigned'=>$salesUser->id],
            ['name'=>'Omar Fathy','phone'=>'+20 102 222 3333','email'=>'omar@example.com','message'=>'Commercial enquiry','product_text'=>'Commercial System','source'=>'Product Page','status'=>'In Progress','assigned'=>$salesUser->id],
            ['name'=>'Laila Hassan','phone'=>'+20 103 444 5555','email'=>'laila@example.com','message'=>'Interested in maintenance','product_text'=>'Maintenance Plan','source'=>'Contact Us','status'=>'New','assigned'=>null],
            ['name'=>'Mohamed Nabil','phone'=>'+20 104 666 7777','email'=>'mohamed@example.com','message'=>'Bulk order request','product_text'=>'Panels x50','source'=>'Manual','status'=>'In Progress','assigned'=>$salesUser->id],
            ['name'=>'Nora Adel','phone'=>'+20 105 888 9999','email'=>'nora@example.com','message'=>'General question','product_text'=>'Accessories','source'=>'Excel Import','status'=>'Closed','assigned'=>null],
        ];

        foreach ($demoLeads as $idx => $ldata) {
            $source = LeadSource::firstWhere('name', $ldata['source']);
            $status = LeadStatus::firstWhere('name', $ldata['status']);

            $lead = Lead::updateOrCreate(
                ['email' => $ldata['email']],
                [
                    'name' => $ldata['name'],
                    'phone' => $ldata['phone'],
                    'email' => $ldata['email'],
                    'message' => $ldata['message'],
                    'product_text' => $ldata['product_text'],
                    'source_id' => $source ? $source->id : null,
                    'status_id' => $status ? $status->id : null,
                    'assigned_to' => $ldata['assigned'],
                    'created_by' => $adminUser ? $adminUser->id : null,
                ]
            );

            // Comments: 1-3 deterministic by index (only if table exists)
            if (Schema::hasTable('lead_comments')) {
                $commentsCount = ($idx % 3) + 1;
                for ($c = 0; $c < $commentsCount; $c++) {
                    $author = ($c % 2 === 0) ? ($adminUser ? $adminUser->id : $salesUser->id) : $salesUser->id;
                    LeadComment::create([
                        'lead_id' => $lead->id,
                        'user_id' => $author,
                        'comment' => "Demo comment #".($c+1)." for {$lead->name}",
                    ]);
                }
            }

            // Actions: 1-2 (only if lead_actions table exists)
            if (Schema::hasTable('lead_actions') && Schema::hasTable('action_types')) {
                $actionTypes = ActionType::pluck('id')->toArray();
                if (count($actionTypes) > 0) {
                    $actionsCount = ($idx % 2) + 1;
                    for ($a = 0; $a < $actionsCount; $a++) {
                        $atype = $actionTypes[($idx + $a) % count($actionTypes)];
                        $action = LeadAction::create([
                            'lead_id' => $lead->id,
                            'action_type_id' => $atype,
                            'user_id' => $salesUser->id,
                            'notes' => "Demo action notes",
                            'scheduled_at' => now()->addDays($a),
                        ]);

                        // Optionally add followups for some actions (only if followups table exists)
                        if (Schema::hasTable('lead_followups') && $a % 2 === 0) {
                            // create 0-2 followups based on idx
                            $followups = ($idx % 3);
                            for ($f = 0; $f < $followups; $f++) {
                                $scheduled = match($f) {
                                    0 => now()->setTime(14,0), // today
                                    1 => now()->subDays(1)->setTime(10,0), // overdue
                                    default => now()->addDays(2)->setTime(11,0),
                                };

                                LeadFollowUp::create([
                                    'lead_id' => $lead->id,
                                    'lead_action_id' => $action->id,
                                    'assigned_to' => $salesUser->id,
                                    'created_by' => $adminUser ? $adminUser->id : $salesUser->id,
                                    'note' => 'Demo followup',
                                    'scheduled_at' => $scheduled,
                                    'completed' => $f === 0 ? false : true,
                                    'completed_at' => $f === 0 ? null : now()->subDay(),
                                ]);
                            }
                        }
                    }
                }
            }
        }
    }
}
