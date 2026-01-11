<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class LeadResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'message' => $this->message,
            'product_text' => $this->product_text,
            'source' => $this->whenLoaded('source'),
            'status' => $this->whenLoaded('status'),
            'assigned_to' => $this->assigned_to,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'comments' => LeadCommentResource::collection($this->whenLoaded('comments')),
            'actions' => LeadActionResource::collection($this->whenLoaded('actions')),
            'follow_ups' => LeadFollowUpResource::collection($this->whenLoaded('followUps')),
        ];
    }
}
