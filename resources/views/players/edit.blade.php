<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Speler Bewerken: {{ $player->name }}</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('players.update', $player) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Naam *</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $player->name) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email *</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $player->email) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
                        </div>
                        <div class="mb-4">
                            <label for="date_of_birth" class="block text-gray-700 text-sm font-bold mb-2">Geboortedatum *</label>
                            <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', $player->date_of_birth->format('Y-m-d')) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
                        </div>
                        <div class="mb-4">
                            <label for="team_id" class="block text-gray-700 text-sm font-bold mb-2">Team *</label>
                            <select name="team_id" id="team_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
                                @foreach($teams as $team)
                                    <option value="{{ $team->id }}" {{ old('team_id', $player->team_id) == $team->id ? 'selected' : '' }}>{{ $team->name }} ({{ $team->sport->name }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="position" class="block text-gray-700 text-sm font-bold mb-2">Positie</label>
                            <input type="text" name="position" id="position" value="{{ old('position', $player->position) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                        </div>
                        <div class="mb-4">
                            <label for="jersey_number" class="block text-gray-700 text-sm font-bold mb-2">Rugnummer</label>
                            <input type="number" name="jersey_number" id="jersey_number" value="{{ old('jersey_number', $player->jersey_number) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" min="1" max="999">
                        </div>
                        <div class="flex items-center justify-between">
                            <a href="{{ route('players.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Annuleren</a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Bijwerken</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
