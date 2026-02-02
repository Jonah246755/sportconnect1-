<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $team->name }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('teams.edit', $team) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Bewerken</a>
                <a href="{{ route('teams.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Terug</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Team Info -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Team Informatie</h3>
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Sport</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $team->sport->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Leeftijdsgroep</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $team->age_group ?? '-' }}</dd>
                        </div>
                        <div class="col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Beschrijving</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $team->description ?? 'Geen beschrijving' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Wedstrijd Statistieken</h3>
                        <dl class="space-y-2">
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600">Gespeeld</dt>
                                <dd class="text-sm font-semibold">{{ $matchStats['played'] }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600">Gewonnen</dt>
                                <dd class="text-sm font-semibold text-green-600">{{ $matchStats['wins'] }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600">Gelijk</dt>
                                <dd class="text-sm font-semibold text-gray-600">{{ $matchStats['draws'] }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600">Verloren</dt>
                                <dd class="text-sm font-semibold text-red-600">{{ $matchStats['losses'] }}</dd>
                            </div>
                            <div class="flex justify-between border-t pt-2">
                                <dt class="text-sm text-gray-600">Doelpunten voor</dt>
                                <dd class="text-sm font-semibold">{{ $matchStats['goals_for'] }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600">Doelpunten tegen</dt>
                                <dd class="text-sm font-semibold">{{ $matchStats['goals_against'] }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Training Statistieken</h3>
                        <div class="text-center">
                            <div class="text-4xl font-bold text-blue-600">{{ $averageAttendance }}%</div>
                            <div class="text-sm text-gray-600 mt-2">Gemiddelde Opkomst</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Players -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Spelers ({{ $team->players->count() }})</h3>
                    @if($team->players->isEmpty())
                        <p class="text-gray-500">Nog geen spelers in dit team.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Naam</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Positie</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rugnummer</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($team->players as $player)
                                        <tr>
                                            <td class="px-6 py-4">
                                                <a href="{{ route('players.show', $player) }}" class="text-blue-600 hover:text-blue-900">{{ $player->name }}</a>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $player->position ?? '-' }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $player->jersey_number ?? '-' }}</td>
                                            <td class="px-6 py-4 text-sm">
                                                @if($player->isInjured())
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Geblesseerd</span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Fit</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
