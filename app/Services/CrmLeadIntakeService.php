<?php

namespace App\Services;

use App\Models\Lead;
use App\Models\LeadSource;
use App\Models\LeadStatus;
use Illuminate\Support\Facades\Schema;

class CrmLeadIntakeService
{
    /**
     * Create a lead from a product page download request.
     * Ensures required source/status rows exist (firstOrCreate).
     */
    public function createFromProductPageDownload(array $data): Lead
    {
        $source = LeadSource::firstOrCreate(['name' => 'Product Page']);
        if (Schema::hasColumn((new LeadSource)->getTable(), 'is_active') && $source->is_active === null) {
            $source->is_active = true;
            $source->save();
        }

        $status = LeadStatus::firstOrCreate(['name' => 'New']);
        if (Schema::hasColumn((new LeadStatus)->getTable(), 'is_active') && $status->is_active === null) {
            $status->is_active = true;
            $status->save();
        }

        $lead = Lead::create([
            'name' => $data['name'] ?? null,
            'phone' => $data['phone'] ?? null,
            'email' => $data['email'] ?? null,
            'message' => $data['subject'] ?? null,
            'product_text' => $data['product_name'] ?? ($data['product'] ?? null),
            'source_id' => $source->id,
            'status_id' => $status->id,
            'created_by' => null,
        ]);

        return $lead;
    }

    /**
     * Create a lead from a contact us submission.
     */
    public function createFromContactUs(array $data): Lead
    {
        $source = LeadSource::firstOrCreate(['name' => 'Contact Us']);
        if (Schema::hasColumn((new LeadSource)->getTable(), 'is_active') && $source->is_active === null) {
            $source->is_active = true;
            $source->save();
        }

        $status = LeadStatus::firstOrCreate(['name' => 'New']);
        if (Schema::hasColumn((new LeadStatus)->getTable(), 'is_active') && $status->is_active === null) {
            $status->is_active = true;
            $status->save();
        }

        $lead = Lead::create([
            'name' => $data['name'] ?? null,
            'phone' => $data['phone'] ?? null,
            'email' => $data['email'] ?? null,
            'message' => $data['message'] ?? ($data['subject'] ?? null),
            'product_text' => null,
            'source_id' => $source->id,
            'status_id' => $status->id,
            'created_by' => null,
        ]);

        return $lead;
    }
}
