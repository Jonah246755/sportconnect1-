<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $sport->name }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('sports.edit', $sport) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    Bewerken
                </a>
                <a href="{{ route('sports.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Terug
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-2">Beschrijving</h3>
                    <p class="text-gray-700">{{ $sport->description ?? 'Geen beschrijving' }}</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Teams ({{ $sport->teams->count() }})</h3>
                    @if($sport->teams->isEmpty())
                        <p class="text-gray-500">Nog geen teams voor deze sport.</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($sport->teams as $team)
                                <div class="border rounded-lg p-4">
                                    <h4 class="font-semibold">{{ $team->name }}</h4>
                                    @if($team->age_group)
                                        <p class="text-sm text-gray-600">{{ $team->age_group }}</p>
                                    @endif
                                    <p class="text-sm text-gray-500 mt-2">
                                        {{ $team->players->count() }} {{ $team->players->count() === 1 ? 'speler' : 'spelers' }}
                                    </p>
                                    <a href="{{ route('teams.show', $team) }}" class="text-blue-600 hover:text-blue-800 text-sm mt-2 inline-block">
                                        Bekijk team →
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
