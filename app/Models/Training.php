<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Training extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'scheduled_at',
        'location',
        'notes',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    /**
     * Get the team for this training
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get all attendance records for this training
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(TrainingAttendance::class);
    }

    /**
     * Get attendance percentage for this training
     */
    public function getAttendancePercentage()
    {
        $total = $this->attendances->count();
        
        if ($total === 0) {
            return 0;
        }

        $attended = $this->attendances->where('attended', true)->count();
        
        return round(($attended / $total) * 100, 2);
    }
}
