<?php

namespace App\Http\Controllers\Crm\Sales;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\LeadFollowUp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        
        // My leads count (assigned to this sales user)
        $myLeadsCount = Lead::where('assigned_to', $userId)->count();
        
        // Followups today (not completed, scheduled <= end of today)
        $todayEnd = now()->endOfDay();
        $followupsTodayCount = 0;
        $overdueFollowupsCount = 0;
        $todayFollowups = collect();
        
        if (Schema::hasTable('lead_follow_ups')) {
            $followupsTodayCount = LeadFollowUp::where('completed', false)
                ->where('assigned_to', $userId)
                ->where('scheduled_at', '<=', $todayEnd)
                ->count();
            
            // Overdue followups (scheduled before today, not completed)
            $overdueFollowupsCount = LeadFollowUp::where('completed', false)
                ->where('assigned_to', $userId)
                ->where('scheduled_at', '<', now()->startOfDay())
                ->count();
            
            // Today's followups for display
            $todayFollowups = LeadFollowUp::with('lead')
                ->where('completed', false)
                ->where('assigned_to', $userId)
                ->where('scheduled_at', '<=', $todayEnd)
                ->orderBy('scheduled_at', 'asc')
                ->get();
        }
        
        // Recent leads assigned to me (with timeline context)
        $recentLeads = Lead::with([
                'status',
                'source',
                'lastAction.type',
                'nextAction.type',
                'lastComment',
            ])
            ->where('assigned_to', $userId)
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();
        
        return view('crm.sales.dashboard', compact(
            'myLeadsCount',
            'followupsTodayCount',
            'overdueFollowupsCount',
            'todayFollowups',
            'recentLeads'
        ));
    }
}
