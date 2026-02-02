<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Injury extends Model
{
    use HasFactory;

    protected $fillable = [
        'player_id',
        'type',
        'description',
        'injury_date',
        'expected_recovery_date',
        'actual_recovery_date',
        'status',
    ];

    protected $casts = [
        'injury_date' => 'date',
        'expected_recovery_date' => 'date',
        'actual_recovery_date' => 'date',
    ];

    /**
     * Get the player this injury belongs to
     */
    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    /**
     * Get the duration of the injury in days
     */
    public function getDurationInDays()
    {
        $endDate = $this->actual_recovery_date ?? now();
        return $this->injury_date->diffInDays($endDate);
    }

    /**
     * Check if injury is overdue (past expected recovery date)
     */
    public function isOverdue(): bool
    {
        if ($this->status === 'recovered' || !$this->expected_recovery_date) {
            return false;
        }
        
        return now()->isAfter($this->expected_recovery_date);
    }
}
