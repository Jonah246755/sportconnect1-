<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-500 text-sm">Sporten</div>
                        <div class="text-3xl font-bold text-gray-800">{{ $totalSports }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-500 text-sm">Teams</div>
                        <div class="text-3xl font-bold text-gray-800">{{ $totalTeams }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-500 text-sm">Spelers</div>
                        <div class="text-3xl font-bold text-gray-800">{{ $totalPlayers }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-500 text-sm">Trainingen</div>
                        <div class="text-3xl font-bold text-gray-800">{{ $totalTrainings }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-500 text-sm">Wedstrijden</div>
                        <div class="text-3xl font-bold text-gray-800">{{ $totalMatches }}</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Active Injuries -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Actieve Blessures ({{ $activeInjuries->count() }})</h3>
                        @if($activeInjuries->isEmpty())
                            <p class="text-gray-500">Geen actieve blessures</p>
                        @else
                            <div class="space-y-3">
                                @foreach($activeInjuries as $injury)
                                    <div class="border-l-4 border-red-500 pl-4">
                                        <div class="font-semibold">{{ $injury->player->name }}</div>
                                        <div class="text-sm text-gray-600">{{ $injury->type }} -
                                            {{ $injury->player->team->name }}</div>
                                        <div class="text-xs text-gray-500">
                                            Status: <span class="font-medium">{{ ucfirst($injury->status) }}</span>
                                            @if($injury->expected_recovery_date)
                                                | Verwacht herstel: {{ $injury->expected_recovery_date->format('d-m-Y') }}
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <div class="mt-4">
                            <a href="{{ route('injuries.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                Alle blessures bekijken →
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Upcoming Trainings -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Aankomende Trainingen</h3>
                        @if($upcomingTrainings->isEmpty())
                            <p class="text-gray-500">Geen aankomende trainingen</p>
                        @else
                            <div class="space-y-3">
                                @foreach($upcomingTrainings as $training)
                                    <div class="border-l-4 border-blue-500 pl-4">
                                        <div class="font-semibold">{{ $training->team->name }}</div>
                                        <div class="text-sm text-gray-600">
                                            {{ $training->scheduled_at->format('d-m-Y H:i') }}
                                        </div>
                                        @if($training->location)
                                            <div class="text-xs text-gray-500">{{ $training->location }}</div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <div class="mt-4">
                            <a href="{{ route('trainings.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                Alle trainingen bekijken →
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Upcoming Matches -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Aankomende Wedstrijden</h3>
                        @if($upcomingMatches->isEmpty())
                            <p class="text-gray-500">Geen aankomende wedstrijden</p>
                        @else
                            <div class="space-y-3">
                                @foreach($upcomingMatches as $match)
                                    <div class="border-l-4 border-green-500 pl-4">
                                        <div class="font-semibold">
                                            {{ $match->homeTeam->name }} vs {{ $match->awayTeam->name }}
                                        </div>
                                        <div class="text-sm text-gray-600">
                                            {{ $match->scheduled_at->format('d-m-Y H:i') }}
                                        </div>
                                        @if($match->location)
                                            <div class="text-xs text-gray-500">{{ $match->location }}</div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <div class="mt-4">
                            <a href="{{ route('matches.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                Alle wedstrijden bekijken →
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Recent Results -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Recente Uitslagen</h3>
                        @if($recentResults->isEmpty())
                            <p class="text-gray-500">Geen recente uitslagen</p>
                        @else
                            <div class="space-y-3">
                                @foreach($recentResults as $match)
                                    <div class="border-l-4 border-purple-500 pl-4">
                                        <div class="font-semibold">
                                            {{ $match->homeTeam->name }} {{ $match->home_score }} - {{ $match->away_score }}
                                            {{ $match->awayTeam->name }}
                                        </div>
                                        <div class="text-sm text-gray-600">
                                            {{ $match->scheduled_at->format('d-m-Y') }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <div class="mt-4">
                            <a href="{{ route('matches.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                Alle wedstrijden bekijken →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>