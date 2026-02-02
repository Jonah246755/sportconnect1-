<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $player->name }}</h2>
            <div class="space-x-2">
                <a href="{{ route('players.edit', $player) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Bewerken</a>
                <a href="{{ route('players.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Terug</a>
            </div>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Speler Informatie</h3>
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div><dt class="text-sm font-medium text-gray-500">Email</dt><dd class="mt-1 text-sm text-gray-900">{{ $player->email }}</dd></div>
                        <div><dt class="text-sm font-medium text-gray-500">Geboortedatum</dt><dd class="mt-1 text-sm text-gray-900">{{ $player->date_of_birth->format('d-m-Y') }} ({{ $player->getAge() }} jaar)</dd></div>
                        <div><dt class="text-sm font-medium text-gray-500">Team</dt><dd class="mt-1 text-sm text-gray-900"><a href="{{ route('teams.show', $player->team) }}" class="text-blue-600">{{ $player->team->name }}</a></dd></div>
                        <div><dt class="text-sm font-medium text-gray-500">Sport</dt><dd class="mt-1 text-sm text-gray-900">{{ $player->team->sport->name }}</dd></div>
                        <div><dt class="text-sm font-medium text-gray-500">Positie</dt><dd class="mt-1 text-sm text-gray-900">{{ $player->position ?? '-' }}</dd></div>
                        <div><dt class="text-sm font-medium text-gray-500">Rugnummer</dt><dd class="mt-1 text-sm text-gray-900">{{ $player->jersey_number ?? '-' }}</dd></div>
                    </dl>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Training Aanwezigheid</h3>
                        <div class="text-center"><div class="text-4xl font-bold text-blue-600">{{ $attendancePercentage }}%</div><div class="text-sm text-gray-600 mt-2">Gemiddelde Opkomst</div></div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Actieve Blessures</h3>
                        @if($activeInjuries->isEmpty())
                            <p class="text-green-600 font-semibold">Geen actieve blessures</p>
                        @else
                            <div class="space-y-2">
                                @foreach($activeInjuries as $injury)
                                    <div class="border-l-4 border-red-500 pl-3">
                                        <div class="font-semibold text-red-600">{{ $injury->type }}</div>
                                        <div class="text-sm text-gray-600">Sinds: {{ $injury->injury_date->format('d-m-Y') }}</div>
                                        @if($injury->expected_recovery_date)
                                            <div class="text-xs text-gray-500">Verwacht herstel: {{ $injury->expected_recovery_date->format('d-m-Y') }}</div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Blessure Geschiedenis</h3>
                    @if($player->injuries->isEmpty())
                        <p class="text-gray-500">Geen blessures geregistreerd.</p>
                    @else
                        <div class="space-y-3">
                            @foreach($player->injuries as $injury)
                                <div class="border rounded p-3">
                                    <div class="flex justify-between items-start"><div><h4 class="font-semibold">{{ $injury->type }}</h4><p class="text-sm text-gray-600">{{ $injury->injury_date->format('d-m-Y') }}</p></div><span class="px-2 py-1 text-xs rounded {{ $injury->status === 'recovered' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">{{ ucfirst($injury->status) }}</span></div>
                                    @if($injury->description)
                                        <p class="text-sm text-gray-600 mt-2">{{ $injury->description }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
