<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameMatch extends Model
{
    use HasFactory;

    protected $table = 'matches'; // Still use the matches table

    protected $fillable = [
        'home_team_id',
        'away_team_id',
        'scheduled_at',
        'location',
        'home_score',
        'away_score',
        'status',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    /**
     * Get the home team
     */
    public function homeTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    /**
     * Get the away team
     */
    public function awayTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    /**
     * Get the match result (win/loss/draw) from home team perspective
     */
    public function getResult()
    {
        if ($this->status !== 'completed' || $this->home_score === null || $this->away_score === null) {
            return null;
        }

        if ($this->home_score > $this->away_score) {
            return 'home_win';
        } elseif ($this->home_score < $this->away_score) {
            return 'away_win';
        } else {
            return 'draw';
        }
    }

    /**
     * Get winner team
     */
    public function getWinner()
    {
        $result = $this->getResult();

        if ($result === 'home_win') {
            return $this->homeTeam;
        } elseif ($result === 'away_win') {
            return $this->awayTeam;
        }

        return null;
    }
}
