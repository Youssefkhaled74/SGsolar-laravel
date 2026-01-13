<?php

namespace App\Http\Controllers\Crm\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\LeadComment;
use App\Models\LeadAction;
use App\Models\LeadFollowUp;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\ActionType;
use App\Models\LeadSource;
use App\Models\LeadStatus;
use App\Models\User;
use App\Http\Requests\Crm\AssignLeadRequest;
use App\Http\Requests\Crm\ChangeLeadStatusRequest;
use App\Http\Requests\Crm\StoreLeadCommentRequest;
use App\Http\Requests\Crm\StoreLeadActionRequest;
use App\Http\Requests\Crm\StoreLeadFollowupRequest;
use App\Http\Requests\Crm\MarkFollowupDoneRequest;
use App\Http\Requests\Crm\StoreLeadRequest;
use Illuminate\Support\Facades\Log;

class LeadController extends Controller
{
    public function index()
    {
        $q = Lead::with(['source','status','assignedTo']);

        // Filters
        if ($search = request('q')) {
            $q->where(function($w) use ($search) {
                $w->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($status = request('status_id')) {
            $q->where('status_id', $status);
        }

        if ($source = request('source_id')) {
            $q->where('source_id', $source);
        }

        if ($assigned = request('assigned_to')) {
            $q->where('assigned_to', $assigned);
        }

        $leads = $q->orderBy('created_at','desc')->paginate(15)->withQueryString();

        $statuses = LeadStatus::orderBy('sort_order')->get();
        $sources = LeadSource::orderBy('name')->get();
        $sales = User::whereHas('role', function($r){ $r->where('name','sales'); })->get();

        return view('crm.admin.leads.index', compact('leads','statuses','sources','sales'));
    }

    public function create()
    {
        $statuses = LeadStatus::orderBy('sort_order')->get();
        $sources = LeadSource::orderBy('name')->get();
        $sales = User::whereHas('role', function($r){ $r->where('name','sales'); })->get();

        return view('crm.admin.leads.create', compact('statuses','sources','sales'));
    }

    public function show($lead)
    {
        $leadModel = Lead::with(['source','status','assignedTo'])->findOrFail($lead);

        $comments = Schema::hasTable('lead_comments') ? LeadComment::where('lead_id', $leadModel->id)->with('author')->orderBy('created_at','desc')->get() : collect();
        $actions = Schema::hasTable('lead_actions') ? LeadAction::where('lead_id', $leadModel->id)->with('type')->orderBy('scheduled_at','desc')->get() : collect();
        $followups = Schema::hasTable('lead_followups') ? LeadFollowUp::where('lead_id', $leadModel->id)->orderBy('scheduled_at','asc')->get() : collect();

        $actionTypes = ActionType::orderBy('name')->get();
        $sales = User::whereHas('role', function($r){ $r->where('name','sales'); })->get();

        return view('crm.admin.leads.show', [
            'lead' => $leadModel,
            'comments' => $comments,
            'actions' => $actions,
            'followups' => $followups,
            'actionTypes' => $actionTypes,
            'sales' => $sales,
        ]);
    }

    public function assign(AssignLeadRequest $request, Lead $lead): RedirectResponse
    {
        $assignedId = $request->validated()['assigned_to'];
        $assignee = User::find($assignedId);

        if ($assignee && ! $assignee->isSales()) {
            abort(403, 'Can only assign to sales users.');
        }

        $lead->assigned_to = $assignedId;
        $lead->save();

        return redirect()->route('crm.admin.leads.show', $lead->id)->with('success', 'Lead assigned.');
    }

    public function status(ChangeLeadStatusRequest $request, Lead $lead): RedirectResponse
    {
        $lead->status_id = $request->validated()['status_id'];
        $lead->save();

        return redirect()->route('crm.admin.leads.show', $lead->id)->with('success', 'Status updated.');
    }

    public function storeComment(StoreLeadCommentRequest $request, Lead $lead): RedirectResponse
    {
        LeadComment::create([
            'lead_id' => $lead->id,
            'user_id' => Auth::id(),
            'comment' => $request->validated()['comment'],
        ]);

        return redirect()->route('crm.admin.leads.show', $lead->id)->with('success', 'Comment added.');
    }

    public function storeAction(StoreLeadActionRequest $request, Lead $lead): RedirectResponse
    {
        LeadAction::create([
            'lead_id' => $lead->id,
            'action_type_id' => $request->validated()['action_type_id'],
            'user_id' => Auth::id(),
            'notes' => $request->validated()['notes'] ?? null,
            'scheduled_at' => $request->validated()['scheduled_at'] ?? null,
        ]);

        return redirect()->route('crm.admin.leads.show', $lead->id)->with('success', 'Action logged.');
    }

    public function storeFollowup(StoreLeadFollowupRequest $request, Lead $lead): RedirectResponse
    {
        LeadFollowUp::create([
            'lead_id' => $lead->id,
            'lead_action_id' => $request->validated()['lead_action_id'] ?? null,
            'assigned_to' => $request->validated()['assigned_to'] ?? null,
            'created_by' => Auth::id(),
            'note' => $request->validated()['note'] ?? null,
            'scheduled_at' => $request->validated()['scheduled_at'],
        ]);

        return redirect()->route('crm.admin.leads.show', $lead->id)->with('success', 'Followup scheduled.');
    }

    public function markFollowupDone(MarkFollowupDoneRequest $request, LeadFollowUp $followup): RedirectResponse
    {
        $followup->completed = true;
        $followup->completed_at = now();
        $followup->save();

        return redirect()->route('crm.admin.leads.show', $followup->lead_id)->with('success', 'Followup marked done.');
    }

    public function store(StoreLeadRequest $request)
    {
        $data = $request->validated();

        // If assigned_to is provided ensure the user is a sales user
        if (! empty($data['assigned_to'])) {
            $assignee = User::find($data['assigned_to']);
            if (! $assignee || ! $assignee->isSales()) {
                return redirect()->back()->with('error', 'Assigned user must be a sales user.')->withInput();
            }
        }

        $lead = Lead::create(array_merge($data, [
            'created_by' => Auth::id(),
        ]));

        return redirect()->route('crm.admin.leads.show', $lead->id)->with('success', 'Lead created.');
    }
}
