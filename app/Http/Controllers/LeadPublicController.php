<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactLeadRequest;
use App\Http\Requests\ProductInquiryRequest;
use App\Models\Lead;
use App\Models\LeadSource;
use App\Models\LeadStatus;
use App\Models\LeadComment;
use Illuminate\Http\JsonResponse;

class LeadPublicController extends Controller
{
    public function contact(ContactLeadRequest $request): JsonResponse
    {
        $data = $request->validated();

        $source = LeadSource::firstWhere('name', 'Contact Us');
        $status = LeadStatus::firstWhere('name', 'New');

        $lead = Lead::where('phone', $data['phone'])->first();

        $created = false;

        if ($lead) {
            // update optional fields if empty
            $updated = false;
            if (empty($lead->message) && !empty($data['message'])) {
                $lead->message = $data['message'];
                $updated = true;
            }
            if (empty($lead->email) && !empty($data['email'])) {
                $lead->email = $data['email'];
                $updated = true;
            }
            if ($updated) {
                $lead->save();
            }
        } else {
            $lead = Lead::create([
                'name' => $data['name'],
                'phone' => $data['phone'],
                'email' => $data['email'] ?? null,
                'message' => $data['message'] ?? null,
                'product_text' => null,
                'source_id' => $source ? $source->id : null,
                'status_id' => $status ? $status->id : null,
                'created_by' => null,
                'assigned_to' => null,
            ]);

            $created = true;
        }

        // add a lead comment
        LeadComment::create([
            'lead_id' => $lead->id,
            'user_id' => null,
            'comment' => 'New message received via Contact Us: ' . ($data['message'] ?? ''),
        ]);

        return response()->json([
            'success' => true,
            'lead_id' => $lead->id,
            'created' => $created,
        ]);
    }

    public function productInquiry(ProductInquiryRequest $request): JsonResponse
    {
        $data = $request->validated();

        $source = LeadSource::firstWhere('name', 'Product Page');
        $status = LeadStatus::firstWhere('name', 'New');

        $lead = Lead::where('phone', $data['phone'])->first();

        $created = false;

        if ($lead) {
            $updated = false;
            if (empty($lead->product_text) && !empty($data['product_text'])) {
                $lead->product_text = $data['product_text'];
                $updated = true;
            }
            if (empty($lead->message) && !empty($data['message'])) {
                $lead->message = $data['message'];
                $updated = true;
            }
            if (empty($lead->email) && !empty($data['email'])) {
                $lead->email = $data['email'];
                $updated = true;
            }
            if ($updated) {
                $lead->save();
            }
        } else {
            $lead = Lead::create([
                'name' => $data['name'],
                'phone' => $data['phone'],
                'email' => $data['email'] ?? null,
                'message' => $data['message'] ?? null,
                'product_text' => $data['product_text'] ?? null,
                'source_id' => $source ? $source->id : null,
                'status_id' => $status ? $status->id : null,
                'created_by' => null,
                'assigned_to' => null,
            ]);

            $created = true;
        }

        LeadComment::create([
            'lead_id' => $lead->id,
            'user_id' => null,
            'comment' => 'New product inquiry via Product Page: ' . ($data['product_text'] ?? ($data['message'] ?? '')),
        ]);

        return response()->json([
            'success' => true,
            'lead_id' => $lead->id,
            'created' => $created,
        ]);
    }
}
