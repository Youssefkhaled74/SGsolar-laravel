<?php

namespace App\Http\Controllers\Crm\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\LeadFollowUp;
use App\Models\LeadAction;
use App\Models\LeadComment;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    public function index()
    {
        $totalLeads = Lead::count();
        $newLeads = Lead::where('created_at', '>=', now()->subDays(7))->count();
        $unassigned = Lead::whereNull('assigned_to')->orWhere('assigned_to', 0)->count();

        $followupsToday = LeadFollowUp::where('completed', false)
            ->where('scheduled_at', '<=', now()->endOfDay())
            ->count();

        // Recent activity: mix of actions, comments and followups
        $actions = LeadAction::with(['user','lead'])->orderBy('created_at','desc')->take(8)->get()->map(function($a){
            return (object) [
                'time' => $a->created_at,
                'actor' => optional($a->user)->name ?: 'System',
                'action' => 'Action: '.optional($a->type)->name ?: 'Action logged',
                'target' => optional($a->lead)->name ?: ('Lead #'.$a->lead_id),
            ];
        });

        $comments = LeadComment::with(['author','lead'])->orderBy('created_at','desc')->take(8)->get()->map(function($c){
            return (object) [
                'time' => $c->created_at,
                'actor' => optional($c->author)->name ?: 'Unknown',
                'action' => 'Comment',
                'target' => optional($c->lead)->name ?: ('Lead #'.$c->lead_id),
            ];
        });

        $followups = LeadFollowUp::with(['lead','creator'])->orderBy('created_at','desc')->take(8)->get()->map(function($f){
            return (object) [
                'time' => $f->created_at,
                'actor' => optional($f->creator)->name ?: 'System',
                'action' => 'Followup scheduled',
                'target' => optional($f->lead)->name ?: ('Lead #'.$f->lead_id),
            ];
        });

        // Merge and sort by time desc, limit 8
        $activities = Collection::make([$actions, $comments, $followups])->flatten(1)
            ->sortByDesc('time')
            ->values()
            ->take(8);

        return view('crm.admin.dashboard', compact('totalLeads','newLeads','unassigned','followupsToday','activities'));
    }
}
