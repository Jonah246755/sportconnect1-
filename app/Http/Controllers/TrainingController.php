<?php

namespace App\Http\Controllers;

use App\Models\Training;
use App\Models\Team;
use App\Models\TrainingAttendance;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    /**
     * Display a listing of trainings
     */
    public function index()
    {
        $trainings = Training::with('team')->orderBy('scheduled_at', 'desc')->get();
        return view('trainings.index', compact('trainings'));
    }

    /**
     * Show the form for creating a new training
     */
    public function create()
    {
        $teams = Team::with('sport')->get();
        return view('trainings.create', compact('teams'));
    }

    /**
     * Store a newly created training
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'team_id' => 'required|exists:teams,id',
            'scheduled_at' => 'required|date',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $training = Training::create($validated);

        // Automatically create attendance records for all players in the team
        $team = Team::find($validated['team_id']);
        foreach ($team->players as $player) {
            TrainingAttendance::create([
                'training_id' => $training->id,
                'player_id' => $player->id,
                'attended' => false,
            ]);
        }

        return redirect()->route('trainings.index')
            ->with('success', 'Training succesvol aangemaakt!');
    }

    /**
     * Display the specified training
     */
    public function show(Training $training)
    {
        $training->load(['team', 'attendances.player']);
        $attendancePercentage = $training->getAttendancePercentage();
        
        return view('trainings.show', compact('training', 'attendancePercentage'));
    }

    /**
     * Show the form for editing the specified training
     */
    public function edit(Training $training)
    {
        $teams = Team::with('sport')->get();
        return view('trainings.edit', compact('training', 'teams'));
    }

    /**
     * Update the specified training
     */
    public function update(Request $request, Training $training)
    {
        $validated = $request->validate([
            'team_id' => 'required|exists:teams,id',
            'scheduled_at' => 'required|date',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $training->update($validated);

        return redirect()->route('trainings.index')
            ->with('success', 'Training succesvol bijgewerkt!');
    }

    /**
     * Remove the specified training
     */
    public function destroy(Training $training)
    {
        $training->delete();

        return redirect()->route('trainings.index')
            ->with('success', 'Training succesvol verwijderd!');
    }

    /**
     * Update attendance for a training
     */
    public function updateAttendance(Request $request, Training $training)
    {
        $validated = $request->validate([
            'attendances' => 'required|array',
            'attendances.*' => 'boolean',
        ]);

        foreach ($validated['attendances'] as $playerId => $attended) {
            TrainingAttendance::updateOrCreate(
                [
                    'training_id' => $training->id,
                    'player_id' => $playerId,
                ],
                [
                    'attended' => $attended,
                ]
            );
        }

        return redirect()->route('trainings.show', $training)
            ->with('success', 'Aanwezigheid succesvol bijgewerkt!');
    }
}
