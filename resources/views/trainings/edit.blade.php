<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Training Bewerken</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('trainings.update', $training) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="team_id" class="block text-gray-700 text-sm font-bold mb-2">Team *</label>
                            <select name="team_id" id="team_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
                                @foreach($teams as $team)
                                    <option value="{{ $team->id }}" {{ $training->team_id == $team->id ? 'selected' : '' }}>{{ $team->name }} ({{ $team->sport->name }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="scheduled_at" class="block text-gray-700 text-sm font-bold mb-2">Datum & Tijd *</label>
                            <input type="datetime-local" name="scheduled_at" id="scheduled_at" value="{{ $training->scheduled_at->format('Y-m-d\TH:i') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
                        </div>
                        <div class="mb-4">
                            <label for="location" class="block text-gray-700 text-sm font-bold mb-2">Locatie</label>
                            <input type="text" name="location" id="location" value="{{ $training->location }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                        </div>
                        <div class="mb-4">
                            <label for="notes" class="block text-gray-700 text-sm font-bold mb-2">Notities</label>
                            <textarea name="notes" id="notes" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">{{ $training->notes }}</textarea>
                        </div>
                        <div class="flex items-center justify-between">
                            <a href="{{ route('trainings.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Annuleren</a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Bijwerken</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
