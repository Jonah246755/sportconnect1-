<?php

namespace App\Http\Controllers;

use App\Models\Sport;
use Illuminate\Http\Request;

class SportController extends Controller
{
    /**
     * Display a listing of sports
     */
    public function index()
    {
        $sports = Sport::withCount('teams')->get();
        return view('sports.index', compact('sports'));
    }

    /**
     * Show the form for creating a new sport
     */
    public function create()
    {
        return view('sports.create');
    }

    /**
     * Store a newly created sport
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:sports,name',
            'description' => 'nullable|string',
        ]);

        Sport::create($validated);

        return redirect()->route('sports.index')
            ->with('success', 'Sport succesvol aangemaakt!');
    }

    /**
     * Display the specified sport
     */
    public function show(Sport $sport)
    {
        $sport->load('teams.players');
        return view('sports.show', compact('sport'));
    }

    /**
     * Show the form for editing the specified sport
     */
    public function edit(Sport $sport)
    {
        return view('sports.edit', compact('sport'));
    }

    /**
     * Update the specified sport
     */
    public function update(Request $request, Sport $sport)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:sports,name,' . $sport->id,
            'description' => 'nullable|string',
        ]);

        $sport->update($validated);

        return redirect()->route('sports.index')
            ->with('success', 'Sport succesvol bijgewerkt!');
    }

    /**
     * Remove the specified sport
     */
    public function destroy(Sport $sport)
    {
        $sport->delete();

        return redirect()->route('sports.index')
            ->with('success', 'Sport succesvol verwijderd!');
    }
}
