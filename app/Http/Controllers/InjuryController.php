<?php

namespace App\Http\Controllers;

use App\Models\Injury;
use App\Models\Player;
use Illuminate\Http\Request;

class InjuryController extends Controller
{
    /**
     * Display a listing of injuries
     */
    public function index()
    {
        $injuries = Injury::with('player.team')->orderBy('injury_date', 'desc')->get();
        return view('injuries.index', compact('injuries'));
    }

    /**
     * Show the form for creating a new injury
     */
    public function create()
    {
        $players = Player::with('team')->get();
        return view('injuries.create', compact('players'));
    }

    /**
     * Store a newly created injury
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'player_id' => 'required|exists:players,id',
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'injury_date' => 'required|date',
            'expected_recovery_date' => 'nullable|date|after:injury_date',
            'actual_recovery_date' => 'nullable|date|after:injury_date',
            'status' => 'required|in:active,recovering,recovered',
        ]);

        Injury::create($validated);

        return redirect()->route('injuries.index')
            ->with('success', 'Blessure succesvol geregistreerd!');
    }

    /**
     * Display the specified injury
     */
    public function show(Injury $injury)
    {
        $injury->load('player.team');
        $durationInDays = $injury->getDurationInDays();
        $isOverdue = $injury->isOverdue();
        
        return view('injuries.show', compact('injury', 'durationInDays', 'isOverdue'));
    }

    /**
     * Show the form for editing the specified injury
     */
    public function edit(Injury $injury)
    {
        $players = Player::with('team')->get();
        return view('injuries.edit', compact('injury', 'players'));
    }

    /**
     * Update the specified injury
     */
    public function update(Request $request, Injury $injury)
    {
        $validated = $request->validate([
            'player_id' => 'required|exists:players,id',
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'injury_date' => 'required|date',
            'expected_recovery_date' => 'nullable|date|after:injury_date',
            'actual_recovery_date' => 'nullable|date|after:injury_date',
            'status' => 'required|in:active,recovering,recovered',
        ]);

        $injury->update($validated);

        return redirect()->route('injuries.index')
            ->with('success', 'Blessure succesvol bijgewerkt!');
    }

    /**
     * Remove the specified injury
     */
    public function destroy(Injury $injury)
    {
        $injury->delete();

        return redirect()->route('injuries.index')
            ->with('success', 'Blessure succesvol verwijderd!');
    }
}
