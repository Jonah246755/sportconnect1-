<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'date_of_birth',
        'team_id',
        'position',
        'jersey_number',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    /**
     * Get the team this player belongs to
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get all injuries for this player
     */
    public function injuries(): HasMany
    {
        return $this->hasMany(Injury::class);
    }

    /**
     * Get all training attendances for this player
     */
    public function trainingAttendances(): HasMany
    {
        return $this->hasMany(TrainingAttendance::class);
    }

    /**
     * Get active injuries
     */
    public function activeInjuries()
    {
        return $this->injuries()->whereIn('status', ['active', 'recovering'])->get();
    }

    /**
     * Check if player is currently injured
     */
    public function isInjured(): bool
    {
        return $this->injuries()->whereIn('status', ['active', 'recovering'])->exists();
    }

    /**
     * Calculate attendance percentage
     */
    public function getAttendancePercentage()
    {
        $totalTrainings = $this->trainingAttendances->count();
        
        if ($totalTrainings === 0) {
            return 0;
        }

        $attended = $this->trainingAttendances->where('attended', true)->count();
        
        return round(($attended / $totalTrainings) * 100, 2);
    }

    /**
     * Get player age
     */
    public function getAge()
    {
        return $this->date_of_birth->age;
    }
}
