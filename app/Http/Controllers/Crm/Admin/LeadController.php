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
use Illuminate\Http\UploadedFile;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:255'],
            'status_id' => ['nullable', 'integer', 'exists:lead_statuses,id'],
            'source_id' => ['nullable', 'integer', 'exists:lead_sources,id'],
            'assigned_to' => ['nullable', 'integer', 'exists:users,id'],
            'assignment' => ['nullable', 'in:assigned,unassigned'],
            'has_email' => ['nullable', 'in:yes,no'],
            'has_message' => ['nullable', 'in:yes,no'],
            'has_product' => ['nullable', 'in:yes,no'],
            'created_from' => ['nullable', 'date'],
            'created_to' => ['nullable', 'date'],
            'next_action' => ['nullable', 'in:any,none,overdue,today,week'],
            'sort_by' => ['nullable', 'in:newest,oldest,name_asc,name_desc,updated_desc,updated_asc'],
            'per_page' => ['nullable', 'integer', 'in:15,25,50,100'],
        ]);

        $q = Lead::with([
            'source',
            'status',
            'assignedTo',
            'lastAction.type',
            'nextAction.type',
            'lastComment.author',
        ]);

        // Filters
        if ($search = trim((string)($filters['q'] ?? ''))) {
            $q->where(function($w) use ($search) {
                $w->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('product_text', 'like', "%{$search}%");
            });
        }

        if ($status = ($filters['status_id'] ?? null)) {
            $q->where('status_id', $status);
        }

        if ($source = ($filters['source_id'] ?? null)) {
            $q->where('source_id', $source);
        }

        if ($assigned = ($filters['assigned_to'] ?? null)) {
            $q->where('assigned_to', $assigned);
        }

        if (($filters['assignment'] ?? null) === 'assigned') {
            $q->whereNotNull('assigned_to');
        }
        if (($filters['assignment'] ?? null) === 'unassigned') {
            $q->whereNull('assigned_to');
        }

        if (($filters['has_email'] ?? null) === 'yes') {
            $q->whereNotNull('email')->where('email', '!=', '');
        }
        if (($filters['has_email'] ?? null) === 'no') {
            $q->where(function ($w) {
                $w->whereNull('email')->orWhere('email', '');
            });
        }

        if (($filters['has_message'] ?? null) === 'yes') {
            $q->whereNotNull('message')->where('message', '!=', '');
        }
        if (($filters['has_message'] ?? null) === 'no') {
            $q->where(function ($w) {
                $w->whereNull('message')->orWhere('message', '');
            });
        }

        if (($filters['has_product'] ?? null) === 'yes') {
            $q->whereNotNull('product_text')->where('product_text', '!=', '');
        }
        if (($filters['has_product'] ?? null) === 'no') {
            $q->where(function ($w) {
                $w->whereNull('product_text')->orWhere('product_text', '');
            });
        }

        if (! empty($filters['created_from'])) {
            $q->whereDate('created_at', '>=', Carbon::parse($filters['created_from'])->toDateString());
        }
        if (! empty($filters['created_to'])) {
            $q->whereDate('created_at', '<=', Carbon::parse($filters['created_to'])->toDateString());
        }

        $today = now()->startOfDay();
        $weekEnd = now()->addDays(7)->endOfDay();
        $nextAction = $filters['next_action'] ?? null;
        if ($nextAction === 'any') {
            $q->whereExists(function ($sub) {
                $sub->select(DB::raw(1))
                    ->from('lead_actions')
                    ->whereColumn('lead_actions.lead_id', 'leads.id')
                    ->whereNotNull('lead_actions.scheduled_at');
            });
        } elseif ($nextAction === 'none') {
            $q->whereNotExists(function ($sub) {
                $sub->select(DB::raw(1))
                    ->from('lead_actions')
                    ->whereColumn('lead_actions.lead_id', 'leads.id')
                    ->whereNotNull('lead_actions.scheduled_at');
            });
        } elseif ($nextAction === 'overdue') {
            $q->whereExists(function ($sub) {
                $sub->select(DB::raw(1))
                    ->from('lead_actions')
                    ->whereColumn('lead_actions.lead_id', 'leads.id')
                    ->whereNotNull('lead_actions.scheduled_at')
                    ->where('lead_actions.scheduled_at', '<', now());
            });
        } elseif ($nextAction === 'today') {
            $q->whereExists(function ($sub) use ($today) {
                $sub->select(DB::raw(1))
                    ->from('lead_actions')
                    ->whereColumn('lead_actions.lead_id', 'leads.id')
                    ->whereNotNull('lead_actions.scheduled_at')
                    ->whereBetween('lead_actions.scheduled_at', [$today, now()->endOfDay()]);
            });
        } elseif ($nextAction === 'week') {
            $q->whereExists(function ($sub) use ($today, $weekEnd) {
                $sub->select(DB::raw(1))
                    ->from('lead_actions')
                    ->whereColumn('lead_actions.lead_id', 'leads.id')
                    ->whereNotNull('lead_actions.scheduled_at')
                    ->whereBetween('lead_actions.scheduled_at', [$today, $weekEnd]);
            });
        }

        $sortBy = $filters['sort_by'] ?? 'newest';
        if ($sortBy === 'oldest') {
            $q->orderBy('created_at', 'asc');
        } elseif ($sortBy === 'name_asc') {
            $q->orderBy('name', 'asc');
        } elseif ($sortBy === 'name_desc') {
            $q->orderBy('name', 'desc');
        } elseif ($sortBy === 'updated_asc') {
            $q->orderBy('updated_at', 'asc');
        } elseif ($sortBy === 'updated_desc') {
            $q->orderBy('updated_at', 'desc');
        } else {
            $q->orderBy('created_at', 'desc');
        }

        $perPage = (int)($filters['per_page'] ?? 15);
        $leads = $q->paginate($perPage)->withQueryString();

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

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required','file'],
        ]);

        $file = $request->file('file');
        $ext = strtolower($file->getClientOriginalExtension());

        // Only accept CSV uploads for now
        if ($ext !== 'csv') {
            return redirect()->back()->with('error', 'Please upload a CSV file (export Excel as CSV).');
        }

        $path = $file->getRealPath();

        $handle = fopen($path, 'r');
        if (! $handle) {
            return redirect()->back()->with('error', 'Unable to read uploaded file.');
        }

        $header = fgetcsv($handle);
        if (! $header || ! is_array($header)) {
            fclose($handle);
            return redirect()->back()->with('error', 'CSV appears empty or malformed.');
        }

        $columns = array_map(function($c){ return strtolower(trim($c)); }, $header);

        $created = 0;
        $errors = [];
        $rowNumber = 1;

        while (($row = fgetcsv($handle)) !== false) {
            $rowNumber++;
            $data = [];
            foreach ($columns as $i => $col) {
                $data[$col] = isset($row[$i]) ? trim($row[$i]) : null;
            }

            // Require name
            if (empty($data['name'])) {
                $errors[] = "Row {$rowNumber}: missing name.";
                continue;
            }

            // Map source/status by name if provided
            $sourceId = null;
            if (! empty($data['source'])) {
                $src = \App\Models\LeadSource::where('name', $data['source'])->first();
                $sourceId = $src ? $src->id : null;
            }

            $statusId = null;
            if (! empty($data['status'])) {
                $st = \App\Models\LeadStatus::where('name', $data['status'])->first();
                $statusId = $st ? $st->id : null;
            }

            // Assigned to: allow email or numeric id or name
            $assignedTo = null;
            if (! empty($data['assigned_to'])) {
                $val = $data['assigned_to'];
                if (is_numeric($val)) {
                    $u = \App\Models\User::find((int)$val);
                } else {
                    $u = \App\Models\User::where('email', $val)->orWhere('name', $val)->first();
                }
                $assignedTo = $u ? $u->id : null;
            }

            try {
                \App\Models\Lead::create([
                    'name' => $data['name'],
                    'phone' => $data['phone'] ?? null,
                    'email' => $data['email'] ?? null,
                    'message' => $data['message'] ?? null,
                    'product_text' => $data['product_text'] ?? null,
                    'source_id' => $sourceId,
                    'status_id' => $statusId,
                    'assigned_to' => $assignedTo,
                    'created_by' => Auth::id(),
                ]);
                $created++;
            } catch (\Exception $e) {
                Log::error('Lead import row '.$rowNumber.' error: '.$e->getMessage());
                $errors[] = "Row {$rowNumber}: failed to create ({$e->getMessage()})";
            }
        }

        fclose($handle);

        $msg = "Imported {$created} leads.";
        if (! empty($errors)) {
            $msg .= ' Some rows failed.';
            return redirect()->back()->with('success', $msg)->with('import_errors', $errors);
        }

        return redirect()->back()->with('success', $msg);
    }
}
