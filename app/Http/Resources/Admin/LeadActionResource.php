<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class LeadActionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'action_type_id' => $this->action_type_id,
            'user_id' => $this->user_id,
            'notes' => $this->notes,
            'scheduled_at' => $this->scheduled_at,
            'completed_at' => $this->completed_at,
            'created_at' => $this->created_at,
        ];
    }
}
