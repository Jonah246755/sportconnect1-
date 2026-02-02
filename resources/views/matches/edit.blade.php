<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Wedstrijd Bewerken</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('matches.update', $match) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="home_team_id" class="block text-gray-700 text-sm font-bold mb-2">Thuisteam *</label>
                            <select name="home_team_id" id="home_team_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
                                @foreach($teams as $team)
                                    <option value="{{ $team->id }}" {{ $match->home_team_id == $team->id ? 'selected' : '' }}>{{ $team->name }} ({{ $team->sport->name }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="away_team_id" class="block text-gray-700 text-sm font-bold mb-2">Uitteam *</label>
                            <select name="away_team_id" id="away_team_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
                                @foreach($teams as $team)
                                    <option value="{{ $team->id }}" {{ $match->away_team_id == $team->id ? 'selected' : '' }}>{{ $team->name }} ({{ $team->sport->name }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="scheduled_at" class="block text-gray-700 text-sm font-bold mb-2">Datum & Tijd *</label>
                            <input type="datetime-local" name="scheduled_at" id="scheduled_at" value="{{ $match->scheduled_at->format('Y-m-d\TH:i') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
                        </div>
                        <div class="mb-4">
                            <label for="location" class="block text-gray-700 text-sm font-bold mb-2">Locatie</label>
                            <input type="text" name="location" id="location" value="{{ $match->location }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                        </div>
                        <div class="mb-4">
                            <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status *</label>
                            <select name="status" id="status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
                                <option value="scheduled" {{ $match->status === 'scheduled' ? 'selected' : '' }}>Gepland</option>
                                <option value="completed" {{ $match->status === 'completed' ? 'selected' : '' }}>Voltooid</option>
                                <option value="cancelled" {{ $match->status === 'cancelled' ? 'selected' : '' }}>Geannuleerd</option>
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="home_score" class="block text-gray-700 text-sm font-bold mb-2">Thuis Score</label>
                                <input type="number" name="home_score" id="home_score" value="{{ $match->home_score }}" min="0" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                            </div>
                            <div>
                                <label for="away_score" class="block text-gray-700 text-sm font-bold mb-2">Uit Score</label>
                                <input type="number" name="away_score" id="away_score" value="{{ $match->away_score }}" min="0" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <a href="{{ route('matches.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Annuleren</a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Bijwerken</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
