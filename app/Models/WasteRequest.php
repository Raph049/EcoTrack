<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WasteRequest extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'user_id',
        'waste_type',
        'quantity',
        'notes',
        'scheduled_time',
        'address',
        'latitude',
        'longitude',
        'collector_id', // <-- NEW
        'assigned_authority_id',
        'status',
        'completion_time',
    ];

    
    protected $casts = [
        'scheduled_time' => 'datetime',
        'completion_time' => 'datetime',
    ];

    
    public function customer(): BelongsTo
    {
        // Links to the User model via the 'user_id' foreign key
        return $this->belongsTo(User::class, 'user_id');
    }

    
    public function collector(): BelongsTo 
    {
        return $this->belongsTo(User::class, 'collector_id');
    }

    
    public function assignedAuthority(): BelongsTo
    {
        // Links to the User model via the 'assigned_authority_id' foreign key
        return $this->belongsTo(User::class, 'assigned_authority_id');
    }
}
