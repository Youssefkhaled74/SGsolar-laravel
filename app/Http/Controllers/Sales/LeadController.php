<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sales\StoreCommentRequest;
use App\Http\Requests\Sales\StoreActionRequest;
use App\Http\Requests\Sales\StoreFollowUpRequest;
use App\Models\Lead;
use App\Models\LeadComment;
use App\Models\LeadAction;
use App\Models\LeadFollowUp;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $leads = Lead::visibleTo($user)->with(['source', 'status', 'assignedTo'])->paginate(25);
        return response()->json($leads);
    }

    public function show(Request $request, Lead $lead)
    {
        $this->authorize('view', $lead);
        $lead->load(['comments', 'actions', 'followUps', 'source', 'status']);
        return response()->json($lead);
    }

    public function storeComment(StoreCommentRequest $request, Lead $lead)
    {
        $this->authorize('comment', $lead);
        $comment = new LeadComment($request->validated());
        $comment->user_id = $request->user()->id;
        $lead->comments()->save($comment);
        return response()->json($comment, 201);
    }

    public function storeAction(StoreActionRequest $request, Lead $lead)
    {
        $this->authorize('createAction', $lead);
        $action = new LeadAction($request->validated());
        $action->user_id = $request->user()->id;
        $lead->actions()->save($action);
        return response()->json($action, 201);
    }

    public function storeFollowUp(StoreFollowUpRequest $request, Lead $lead)
    {
        $this->authorize('createFollowUp', $lead);
        $f = new LeadFollowUp($request->validated());
        $f->user_id = $request->user()->id;
        $lead->followUps()->save($f);
        return response()->json($f, 201);
    }

    public function completeFollowUp(Request $request, Lead $lead, LeadFollowUp $followUp)
    {
        $this->authorize('completeFollowUp', $lead);
        $followUp->update(['completed' => true, 'completed_at' => now()]);
        return response()->json($followUp);
    }
}
