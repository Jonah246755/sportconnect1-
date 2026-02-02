<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrainingAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'training_id',
        'player_id',
        'attended',
        'notes',
    ];

    protected $casts = [
        'attended' => 'boolean',
    ];

    /**
     * Get the training this attendance is for
     */
    public function training(): BelongsTo
    {
        return $this->belongsTo(Training::class);
    }

    /**
     * Get the player this attendance is for
     */
    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }
}
