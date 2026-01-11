<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sort_order',
        'is_default',
        'color',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function leads()
    {
        return $this->hasMany(Lead::class, 'status_id');
    }
}
