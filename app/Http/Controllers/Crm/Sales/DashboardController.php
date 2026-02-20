<?php

namespace App\Http\Controllers\Crm\Sales;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\LeadFollowUp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // My leads count (assigned to this sales user)
        $myLeadsCount = Lead::where('assigned_to', $userId)->count();

        $now = now();
        $todayStart = $now->copy()->startOfDay();
        $todayEnd = $now->copy()->endOfDay();
        $tomorrowStart = $todayEnd->copy()->addSecond();
        $weekEnd = $now->copy()->addDays(7)->endOfDay();

        // Followup KPIs + lists
        $followupsTodayCount = 0;
        $overdueFollowupsCount = 0;
        $upcomingWeekFollowupsCount = 0;
        $completedTodayCount = 0;
        $todayFollowups = collect();
        $priorityFollowups = collect();

        // Support both possible table names in existing environments.
        $followupsTable = null;
        if (Schema::hasTable('lead_follow_ups')) {
            $followupsTable = 'lead_follow_ups';
        } elseif (Schema::hasTable('lead_followups')) {
            $followupsTable = 'lead_followups';
        }

        if ($followupsTable) {
            $followupModel = new LeadFollowUp();
            $followupModel->setTable($followupsTable);

            $baseFollowups = $followupModel->newQuery()
                ->with('lead')
                ->where('assigned_to', $userId);

            $followupsTodayCount = (clone $baseFollowups)
                ->where('completed', false)
                ->whereBetween('scheduled_at', [$todayStart, $todayEnd])
                ->count();

            $overdueFollowupsCount = (clone $baseFollowups)
                ->where('completed', false)
                ->where('scheduled_at', '<', $todayStart)
                ->count();

            $upcomingWeekFollowupsCount = (clone $baseFollowups)
                ->where('completed', false)
                ->whereBetween('scheduled_at', [$tomorrowStart, $weekEnd])
                ->count();

            $completedTodayCount = (clone $baseFollowups)
                ->where('completed', true)
                ->whereBetween('completed_at', [$todayStart, $todayEnd])
                ->count();

            $todayFollowups = (clone $baseFollowups)
                ->where('completed', false)
                ->whereBetween('scheduled_at', [$todayStart, $todayEnd])
                ->orderBy('scheduled_at', 'asc')
                ->get();

            $overduePreview = (clone $baseFollowups)
                ->where('completed', false)
                ->where('scheduled_at', '<', $todayStart)
                ->orderBy('scheduled_at', 'asc')
                ->take(4)
                ->get();

            $todayPreview = (clone $baseFollowups)
                ->where('completed', false)
                ->whereBetween('scheduled_at', [$todayStart, $todayEnd])
                ->orderBy('scheduled_at', 'asc')
                ->take(4)
                ->get();

            $priorityFollowups = $overduePreview->concat($todayPreview)->take(6)->values();
        }

        // Lead intelligence
        $newLeadsThisWeekCount = Lead::where('assigned_to', $userId)
            ->where('created_at', '>=', $now->copy()->startOfWeek())
            ->count();

        $leadsWithoutNextActionCount = Lead::where('assigned_to', $userId)
            ->whereDoesntHave('nextAction')
            ->count();

        $staleLeadsCount = Lead::where('assigned_to', $userId)
            ->where('created_at', '<=', $now->copy()->subDays(7))
            ->whereDoesntHave('lastComment', function ($q) use ($now) {
                $q->where('created_at', '>=', $now->copy()->subDays(7));
            })
            ->whereDoesntHave('lastAction', function ($q) use ($now) {
                $q->where('created_at', '>=', $now->copy()->subDays(7));
            })
            ->count();

        $statusBreakdown = Lead::query()
            ->leftJoin('lead_statuses', 'lead_statuses.id', '=', 'leads.status_id')
            ->where('leads.assigned_to', $userId)
            ->groupBy('leads.status_id', 'lead_statuses.name')
            ->orderByDesc(DB::raw('COUNT(*)'))
            ->selectRaw('COALESCE(lead_statuses.name, ?) as status_name, COUNT(*) as total', ['Unspecified'])
            ->take(6)
            ->get();

        $attentionLeads = Lead::with(['status', 'source'])
            ->where('assigned_to', $userId)
            ->whereDoesntHave('nextAction')
            ->orderBy('updated_at', 'asc')
            ->take(6)
            ->get();

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
            'upcomingWeekFollowupsCount',
            'completedTodayCount',
            'newLeadsThisWeekCount',
            'leadsWithoutNextActionCount',
            'staleLeadsCount',
            'todayFollowups',
            'priorityFollowups',
            'statusBreakdown',
            'attentionLeads',
            'recentLeads'
        ));
    }
}
