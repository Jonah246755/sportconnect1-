<?php

namespace App\Http\Controllers;

use App\Models\Sport;
use App\Models\Team;
use App\Models\Player;
use App\Models\Training;
use App\Models\GameMatch;
use App\Models\Injury;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with overview statistics
     */
    public function index()
    {
        // Get counts
        $totalSports = Sport::count();
        $totalTeams = Team::count();
        $totalPlayers = Player::count();
        $totalTrainings = Training::count();
        $totalMatches = GameMatch::count();
        
        // Get active injuries
        $activeInjuries = Injury::whereIn('status', ['active', 'recovering'])
            ->with('player.team')
            ->get();
        
        // Get upcoming trainings (next 7 days)
        $upcomingTrainings = Training::with('team')
            ->where('scheduled_at', '>=', now())
            ->where('scheduled_at', '<=', now()->addDays(7))
            ->orderBy('scheduled_at')
            ->take(5)
            ->get();
        
        // Get upcoming matches (next 14 days)
        $upcomingMatches = GameMatch::with(['homeTeam', 'awayTeam'])
            ->where('scheduled_at', '>=', now())
            ->where('scheduled_at', '<=', now()->addDays(14))
            ->where('status', 'scheduled')
            ->orderBy('scheduled_at')
            ->take(5)
            ->get();
        
        // Get recent match results
        $recentResults = GameMatch::with(['homeTeam', 'awayTeam'])
            ->where('status', 'completed')
            ->orderBy('scheduled_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalSports',
            'totalTeams',
            'totalPlayers',
            'totalTrainings',
            'totalMatches',
            'activeInjuries',
            'upcomingTrainings',
            'upcomingMatches',
            'recentResults'
        ));
    }
}
