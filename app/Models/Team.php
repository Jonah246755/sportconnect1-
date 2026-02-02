<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sport_id',
        'age_group',
        'description',
    ];

    /**
     * Get the sport this team belongs to
     */
    public function sport(): BelongsTo
    {
        return $this->belongsTo(Sport::class);
    }

    /**
     * Get all players in this team
     */
    public function players(): HasMany
    {
        return $this->hasMany(Player::class);
    }

    /**
     * Get all trainings for this team
     */
    public function trainings(): HasMany
    {
        return $this->hasMany(Training::class);
    }

    /**
     * Get matches where this team is the home team
     */
    public function homeMatches(): HasMany
    {
        return $this->hasMany(GameMatch::class, 'home_team_id');
    }

    /**
     * Get matches where this team is the away team
     */
    public function awayMatches(): HasMany
    {
        return $this->hasMany(GameMatch::class, 'away_team_id');
    }

    /**
     * Get all matches (home and away) for this team
     */
    public function allMatches()
    {
        return GameMatch::where('home_team_id', $this->id)
            ->orWhere('away_team_id', $this->id)
            ->get();
    }

    /**
     * Calculate win/loss/draw statistics
     */
    public function getMatchStats()
    {
        $matches = $this->allMatches()->where('status', 'completed');

        $wins = 0;
        $losses = 0;
        $draws = 0;
        $goalsFor = 0;
        $goalsAgainst = 0;

        foreach ($matches as $match) {
            if ($match->home_team_id == $this->id) {
                $goalsFor += $match->home_score ?? 0;
                $goalsAgainst += $match->away_score ?? 0;

                if ($match->home_score > $match->away_score)
                    $wins++;
                elseif ($match->home_score < $match->away_score)
                    $losses++;
                else
                    $draws++;
            } else {
                $goalsFor += $match->away_score ?? 0;
                $goalsAgainst += $match->home_score ?? 0;

                if ($match->away_score > $match->home_score)
                    $wins++;
                elseif ($match->away_score < $match->home_score)
                    $losses++;
                else
                    $draws++;
            }
        }

        return [
            'played' => $matches->count(),
            'wins' => $wins,
            'losses' => $losses,
            'draws' => $draws,
            'goals_for' => $goalsFor,
            'goals_against' => $goalsAgainst,
        ];
    }

    /**
     * Calculate average training attendance
     */
    public function getAverageAttendance()
    {
        $trainings = $this->trainings;

        if ($trainings->isEmpty()) {
            return 0;
        }

        $totalAttendance = 0;
        $totalPossible = 0;

        foreach ($trainings as $training) {
            $attendances = $training->attendances;
            $totalAttendance += $attendances->where('attended', true)->count();
            $totalPossible += $attendances->count();
        }

        return $totalPossible > 0 ? round(($totalAttendance / $totalPossible) * 100, 2) : 0;
    }
}
