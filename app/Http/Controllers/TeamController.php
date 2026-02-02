<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Sport;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Display a listing of teams
     */
    public function index()
    {
        $teams = Team::with('sport')->withCount('players')->get();
        return view('teams.index', compact('teams'));
    }

    /**
     * Show the form for creating a new team
     */
    public function create()
    {
        $sports = Sport::all();
        return view('teams.create', compact('sports'));
    }

    /**
     * Store a newly created team
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sport_id' => 'required|exists:sports,id',
            'age_group' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);

        Team::create($validated);

        return redirect()->route('teams.index')
            ->with('success', 'Team succesvol aangemaakt!');
    }

    /**
     * Display the specified team
     */
    public function show(Team $team)
    {
        $team->load(['sport', 'players', 'trainings', 'homeMatches', 'awayMatches']);
        
        // Get statistics
        $matchStats = $team->getMatchStats();
        $averageAttendance = $team->getAverageAttendance();
        
        return view('teams.show', compact('team', 'matchStats', 'averageAttendance'));
    }

    /**
     * Show the form for editing the specified team
     */
    public function edit(Team $team)
    {
        $sports = Sport::all();
        return view('teams.edit', compact('team', 'sports'));
    }

    /**
     * Update the specified team
     */
    public function update(Request $request, Team $team)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sport_id' => 'required|exists:sports,id',
            'age_group' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);

        $team->update($validated);

        return redirect()->route('teams.index')
            ->with('success', 'Team succesvol bijgewerkt!');
    }

    /**
     * Remove the specified team
     */
    public function destroy(Team $team)
    {
        $team->delete();

        return redirect()->route('teams.index')
            ->with('success', 'Team succesvol verwijderd!');
    }
}
