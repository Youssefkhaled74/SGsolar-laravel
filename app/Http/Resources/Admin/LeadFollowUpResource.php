<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class LeadFollowUpResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'note' => $this->note,
            'assigned_to' => $this->assigned_to,
            'scheduled_at' => $this->scheduled_at,
            'completed' => (bool) $this->completed,
            'completed_at' => $this->completed_at,
            'created_at' => $this->created_at,
        ];
    }
}
