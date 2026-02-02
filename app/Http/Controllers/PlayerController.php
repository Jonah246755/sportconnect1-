<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    /**
     * Display a listing of players
     */
    public function index()
    {
        $players = Player::with('team.sport')->get();
        return view('players.index', compact('players'));
    }

    /**
     * Show the form for creating a new player
     */
    public function create()
    {
        $teams = Team::with('sport')->get();
        return view('players.create', compact('teams'));
    }

    /**
     * Store a newly created player
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:players,email',
            'date_of_birth' => 'required|date|before:today',
            'team_id' => 'required|exists:teams,id',
            'position' => 'nullable|string|max:100',
            'jersey_number' => 'nullable|integer|min:1|max:999',
        ]);

        Player::create($validated);

        return redirect()->route('players.index')
            ->with('success', 'Speler succesvol aangemaakt!');
    }

    /**
     * Display the specified player
     */
    public function show(Player $player)
    {
        $player->load(['team.sport', 'injuries', 'trainingAttendances.training']);
        
        $attendancePercentage = $player->getAttendancePercentage();
        $activeInjuries = $player->activeInjuries();
        
        return view('players.show', compact('player', 'attendancePercentage', 'activeInjuries'));
    }

    /**
     * Show the form for editing the specified player
     */
    public function edit(Player $player)
    {
        $teams = Team::with('sport')->get();
        return view('players.edit', compact('player', 'teams'));
    }

    /**
     * Update the specified player
     */
    public function update(Request $request, Player $player)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:players,email,' . $player->id,
            'date_of_birth' => 'required|date|before:today',
            'team_id' => 'required|exists:teams,id',
            'position' => 'nullable|string|max:100',
            'jersey_number' => 'nullable|integer|min:1|max:999',
        ]);

        $player->update($validated);

        return redirect()->route('players.index')
            ->with('success', 'Speler succesvol bijgewerkt!');
    }

    /**
     * Remove the specified player
     */
    public function destroy(Player $player)
    {
        $player->delete();

        return redirect()->route('players.index')
            ->with('success', 'Speler succesvol verwijderd!');
    }
}
