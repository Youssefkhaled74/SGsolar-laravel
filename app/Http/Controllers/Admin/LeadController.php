<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\IndexLeadsRequest;
use App\Http\Requests\Admin\StoreLeadRequest;
use App\Http\Requests\Admin\UpdateLeadRequest;
use App\Http\Requests\Admin\AssignLeadRequest;
use App\Http\Requests\Admin\UpdateLeadStatusRequest;
use App\Http\Resources\Admin\LeadResource;
use App\Models\Lead;
use Illuminate\Http\JsonResponse;

class LeadController extends Controller
{
    public function index(IndexLeadsRequest $request): JsonResponse
    {
        $this->authorize('viewAny', Lead::class);

        $q = Lead::query()->with(['source', 'status', 'assignedTo']);

        $filters = $request->validated();

        if (!empty($filters['search'])) {
            $term = $filters['search'];
            $q->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('phone', 'like', "%{$term}%")
                  ->orWhere('email', 'like', "%{$term}%");
            });
        }

        foreach (['source_id','status_id','assigned_to'] as $f) {
            if (!empty($filters[$f])) {
                $q->where($f, $filters[$f]);
            }
        }

        if (!empty($filters['date_from'])) {
            $q->whereDate('created_at', '>=', $filters['date_from']);
        }
        if (!empty($filters['date_to'])) {
            $q->whereDate('created_at', '<=', $filters['date_to']);
        }

        $perPage = $filters['per_page'] ?? 15;

        $page = $q->orderBy('created_at', 'desc')->paginate($perPage);

        return response()->json($page);
    }

    public function show(Lead $lead): JsonResponse
    {
        $this->authorize('view', $lead);

        $lead->load(['source','status','comments','actions','followUps']);

        return response()->json(new LeadResource($lead));
    }

    public function store(StoreLeadRequest $request): JsonResponse
    {
        $this->authorize('create', Lead::class);

        $data = $request->validated();

        $lead = Lead::create($data);

        return response()->json(new LeadResource($lead->load(['source','status'])), 201);
    }

    public function update(UpdateLeadRequest $request, Lead $lead): JsonResponse
    {
        $this->authorize('update', $lead);

        $lead->update($request->validated());

        return response()->json(new LeadResource($lead->load(['source','status'])));
    }

    public function assign(AssignLeadRequest $request, Lead $lead): JsonResponse
    {
        $this->authorize('update', $lead);

        $lead->assigned_to = $request->validated()['assigned_to'];
        $lead->save();

        return response()->json(['success' => true, 'assigned_to' => $lead->assigned_to]);
    }

    public function status(UpdateLeadStatusRequest $request, Lead $lead): JsonResponse
    {
        $this->authorize('update', $lead);

        $lead->status_id = $request->validated()['status_id'];
        $lead->save();

        return response()->json(['success' => true, 'status_id' => $lead->status_id]);
    }
}
