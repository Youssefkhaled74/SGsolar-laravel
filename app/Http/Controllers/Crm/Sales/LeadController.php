<?php

namespace App\Http\Controllers\Crm\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\LeadComment;
use App\Models\LeadAction;
use App\Models\LeadFollowUp;
use App\Models\ActionType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Schema;
use App\Http\Requests\Crm\StoreLeadCommentRequest;
use App\Http\Requests\Crm\StoreLeadActionRequest;
use App\Http\Requests\Crm\StoreLeadFollowupRequest;
use App\Http\Requests\Crm\MarkFollowupDoneRequest;

class LeadController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $q = Lead::with(['source','status','assignedTo'])->where('assigned_to', $userId);

        if ($search = request('q')) {
            $q->where(function($w) use ($search) {
                $w->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $leads = $q->orderBy('created_at','desc')->paginate(15)->withQueryString();

        return view('crm.sales.leads.index', compact('leads'));
    }

    public function show(Lead $lead)
    {
        $userId = Auth::id();
        if ($lead->assigned_to !== $userId) {
            abort(403);
        }

        $comments = Schema::hasTable('lead_comments') ? LeadComment::where('lead_id', $lead->id)->with('author')->orderBy('created_at','desc')->get() : collect();
        $actions = Schema::hasTable('lead_actions') ? LeadAction::where('lead_id', $lead->id)->with('type')->orderBy('scheduled_at','desc')->get() : collect();
        $followups = Schema::hasTable('lead_followups') ? LeadFollowUp::where('lead_id', $lead->id)->orderBy('scheduled_at','asc')->get() : collect();
        $actionTypes = ActionType::orderBy('name')->get();

        return view('crm.sales.leads.show', compact('lead','comments','actions','followups','actionTypes'));
    }

    public function storeComment(StoreLeadCommentRequest $request, Lead $lead): RedirectResponse
    {
        $userId = Auth::id();
        if ($lead->assigned_to !== $userId) abort(403);

        LeadComment::create([
            'lead_id' => $lead->id,
            'user_id' => $userId,
            'comment' => $request->validated()['comment'],
        ]);

        return redirect()->route('crm.sales.leads.show', $lead->id)->with('success','Comment added.');
    }

    public function storeAction(StoreLeadActionRequest $request, Lead $lead): RedirectResponse
    {
        $userId = Auth::id();
        if ($lead->assigned_to !== $userId) abort(403);

        LeadAction::create([
            'lead_id' => $lead->id,
            'action_type_id' => $request->validated()['action_type_id'],
            'user_id' => $userId,
            'notes' => $request->validated()['notes'] ?? null,
            'scheduled_at' => $request->validated()['scheduled_at'] ?? null,
        ]);

        return redirect()->route('crm.sales.leads.show', $lead->id)->with('success','Action logged.');
    }

    public function storeFollowup(StoreLeadFollowupRequest $request, Lead $lead): RedirectResponse
    {
        $userId = Auth::id();
        if ($lead->assigned_to !== $userId) abort(403);

        LeadFollowUp::create([
            'lead_id' => $lead->id,
            'lead_action_id' => $request->validated()['lead_action_id'] ?? null,
            'assigned_to' => $request->validated()['assigned_to'] ?? $userId,
            'created_by' => $userId,
            'note' => $request->validated()['note'] ?? null,
            'scheduled_at' => $request->validated()['scheduled_at'],
        ]);

        return redirect()->route('crm.sales.leads.show', $lead->id)->with('success','Followup scheduled.');
    }

    public function markFollowupDone(MarkFollowupDoneRequest $request, LeadFollowUp $followup): RedirectResponse
    {
        $userId = Auth::id();
        if ($followup->assigned_to !== $userId && $followup->lead && $followup->lead->assigned_to !== $userId) abort(403);

        $followup->completed = true;
        $followup->completed_at = now();
        $followup->save();

        return redirect()->back()->with('success','Followup marked done.');
    }

    public function followupsToday()
    {
        $userId = Auth::id();
        $todayEnd = now()->endOfDay();

        $followups = LeadFollowUp::where('completed', false)
            ->where(function($q) use ($userId) {
                $q->where('assigned_to', $userId)
                  ->orWhereHas('lead', function($l) use ($userId){ $l->where('assigned_to', $userId); });
            })
            ->where('scheduled_at', '<=', $todayEnd)
            ->orderBy('scheduled_at','asc')
            ->get();

        return view('crm.sales.followups.today', compact('followups'));
    }
}
