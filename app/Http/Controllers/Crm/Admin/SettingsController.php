<?php

namespace App\Http\Controllers\Crm\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeadStatus;
use App\Models\LeadSource;
use App\Models\ActionType;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Crm\StoreLeadStatusRequest;
use App\Http\Requests\Crm\UpdateLeadStatusRequest;
use App\Http\Requests\Crm\StoreLeadSourceRequest;
use App\Http\Requests\Crm\UpdateLeadSourceRequest;
use App\Http\Requests\Crm\StoreActionTypeRequest;
use App\Http\Requests\Crm\UpdateActionTypeRequest;

class SettingsController extends Controller
{
    public function index()
    {
        if (Schema::hasColumn('lead_statuses', 'is_active')) {
            $statuses = LeadStatus::orderByDesc('is_active')->orderBy('name')->get();
        } else {
            $statuses = LeadStatus::orderBy('name')->get();
        }

        if (Schema::hasColumn('lead_sources', 'is_active')) {
            $sources = LeadSource::orderByDesc('is_active')->orderBy('name')->get();
        } else {
            $sources = LeadSource::orderBy('name')->get();
        }

        if (Schema::hasColumn('action_types', 'is_active')) {
            $actionTypes = ActionType::orderByDesc('is_active')->orderBy('name')->get();
        } else {
            $actionTypes = ActionType::orderBy('name')->get();
        }

        return view('crm.admin.settings.index', compact('statuses','sources','actionTypes'));
    }

    // Statuses
    public function storeStatus(StoreLeadStatusRequest $request): RedirectResponse
    {
        LeadStatus::create($request->validated());
        return redirect()->route('crm.admin.settings.index')->with('success','Status created.');
    }

    public function updateStatus(UpdateLeadStatusRequest $request, LeadStatus $status): RedirectResponse
    {
        $status->update($request->validated());
        return redirect()->route('crm.admin.settings.index')->with('success','Status updated.');
    }

    public function toggleStatus(Request $request, LeadStatus $status): RedirectResponse
    {
        $status->is_active = ! (bool) $status->is_active;
        $status->save();
        return redirect()->route('crm.admin.settings.index')->with('success','Status toggled.');
    }

    // Sources
    public function storeSource(StoreLeadSourceRequest $request): RedirectResponse
    {
        LeadSource::create($request->validated());
        return redirect()->route('crm.admin.settings.index')->with('success','Source created.');
    }

    public function updateSource(UpdateLeadSourceRequest $request, LeadSource $source): RedirectResponse
    {
        $source->update($request->validated());
        return redirect()->route('crm.admin.settings.index')->with('success','Source updated.');
    }

    public function toggleSource(Request $request, LeadSource $source): RedirectResponse
    {
        $source->is_active = ! (bool) $source->is_active;
        $source->save();
        return redirect()->route('crm.admin.settings.index')->with('success','Source toggled.');
    }

    // Action Types
    public function storeActionType(StoreActionTypeRequest $request): RedirectResponse
    {
        ActionType::create($request->validated());
        return redirect()->route('crm.admin.settings.index')->with('success','Action Type created.');
    }

    public function updateActionType(UpdateActionTypeRequest $request, ActionType $type): RedirectResponse
    {
        $type->update($request->validated());
        return redirect()->route('crm.admin.settings.index')->with('success','Action Type updated.');
    }

    public function toggleActionType(Request $request, ActionType $type): RedirectResponse
    {
        $type->is_active = ! (bool) $type->is_active;
        $type->save();
        return redirect()->route('crm.admin.settings.index')->with('success','Action Type toggled.');
    }
}

