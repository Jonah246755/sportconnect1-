<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nieuwe Blessure</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('injuries.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="player_id" class="block text-gray-700 text-sm font-bold mb-2">Speler *</label>
                            <select name="player_id" id="player_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
                                <option value="">Selecteer een speler</option>
                                @foreach($players as $player)
                                    <option value="{{ $player->id }}">{{ $player->name }} ({{ $player->team->name }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="type" class="block text-gray-700 text-sm font-bold mb-2">Type Blessure *</label>
                            <input type="text" name="type" id="type" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" placeholder="bijv. Enkelblessure" required>
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Beschrijving</label>
                            <textarea name="description" id="description" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700"></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="injury_date" class="block text-gray-700 text-sm font-bold mb-2">Blessure Datum *</label>
                            <input type="date" name="injury_date" id="injury_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
                        </div>
                        <div class="mb-4">
                            <label for="expected_recovery_date" class="block text-gray-700 text-sm font-bold mb-2">Verwacht Herstel Datum</label>
                            <input type="date" name="expected_recovery_date" id="expected_recovery_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                        </div>
                        <div class="mb-4">
                            <label for="actual_recovery_date" class="block text-gray-700 text-sm font-bold mb-2">Werkelijk Herstel Datum</label>
                            <input type="date" name="actual_recovery_date" id="actual_recovery_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                        </div>
                        <div class="mb-4">
                            <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status *</label>
                            <select name="status" id="status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
                                <option value="active">Actief</option>
                                <option value="recovering">Herstellende</option>
                                <option value="recovered">Hersteld</option>
                            </select>
                        </div>
                        <div class="flex items-center justify-between">
                            <a href="{{ route('injuries.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Annuleren</a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Opslaan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
