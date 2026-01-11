<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActionType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'key',
        'description',
        'default_duration_minutes',
    ];

    public function actions()
    {
        return $this->hasMany(LeadAction::class, 'action_type_id');
    }
}
