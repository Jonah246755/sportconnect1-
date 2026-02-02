<?php

namespace App\Http\Controllers;

use App\Models\GameMatch;
use App\Models\Team;
use Illuminate\Http\Request;

class GameMatchController extends Controller
{
    /**
     * Display a listing of matches
     */
    public function index()
    {
        $matches = GameMatch::with(['homeTeam', 'awayTeam'])
            ->orderBy('scheduled_at', 'desc')
            ->get();
        return view('matches.index', compact('matches'));
    }

    /**
     * Show the form for creating a new match
     */
    public function create()
    {
        $teams = Team::with('sport')->get();
        return view('matches.create', compact('teams'));
    }

    /**
     * Store a newly created match
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'home_team_id' => 'required|exists:teams,id',
            'away_team_id' => 'required|exists:teams,id|different:home_team_id',
            'scheduled_at' => 'required|date',
            'location' => 'nullable|string|max:255',
            'home_score' => 'nullable|integer|min:0',
            'away_score' => 'nullable|integer|min:0',
            'status' => 'required|in:scheduled,completed,cancelled',
        ]);

        GameMatch::create($validated);

        return redirect()->route('matches.index')
            ->with('success', 'Wedstrijd succesvol aangemaakt!');
    }

    /**
     * Display the specified match
     */
    public function show(GameMatch $match)
    {
        $match->load(['homeTeam.sport', 'awayTeam']);
        $result = $match->getResult();
        $winner = $match->getWinner();
        
        return view('matches.show', compact('match', 'result', 'winner'));
    }

    /**
     * Show the form for editing the specified match
     */
    public function edit(GameMatch $match)
    {
        $teams = Team::with('sport')->get();
        return view('matches.edit', compact('match', 'teams'));
    }

    /**
     * Update the specified match
     */
    public function update(Request $request, GameMatch $match)
    {
        $validated = $request->validate([
            'home_team_id' => 'required|exists:teams,id',
            'away_team_id' => 'required|exists:teams,id|different:home_team_id',
            'scheduled_at' => 'required|date',
            'location' => 'nullable|string|max:255',
            'home_score' => 'nullable|integer|min:0',
            'away_score' => 'nullable|integer|min:0',
            'status' => 'required|in:scheduled,completed,cancelled',
        ]);

        $match->update($validated);

        return redirect()->route('matches.index')
            ->with('success', 'Wedstrijd succesvol bijgewerkt!');
    }

    /**
     * Remove the specified match
     */
    public function destroy(GameMatch $match)
    {
        $match->delete();

        return redirect()->route('matches.index')
            ->with('success', 'Wedstrijd succesvol verwijderd!');
    }
}
