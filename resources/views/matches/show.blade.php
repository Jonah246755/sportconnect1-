<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $match->homeTeam->name }} vs {{ $match->awayTeam->name }}</h2>
            <div class="space-x-2">
                <a href="{{ route('matches.edit', $match) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Bewerken</a>
                <a href="{{ route('matches.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Terug</a>
            </div>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="text-center mb-6">
                        <div class="text-4xl font-bold mb-2">
                            <span>{{ $match->homeTeam->name }}</span>
                            @if($match->status === 'completed')
                                <span class="mx-4">{{ $match->home_score }} - {{ $match->away_score }}</span>
                            @else
                                <span class="mx-4 text-gray-400">vs</span>
                            @endif
                            <span>{{ $match->awayTeam->name }}</span>
                        </div>
                        <div class="text-gray-600">{{ $match->scheduled_at->format('d-m-Y H:i') }}</div>
                        @if($match->location)
                            <div class="text-sm text-gray-500">{{ $match->location }}</div>
                        @endif
                        <div class="mt-4">
                            <span class="px-3 py-1 rounded {{ $match->status === 'completed' ? 'bg-green-100 text-green-800' : ($match->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ ucfirst($match->status) }}
                            </span>
                        </div>
                        @if($result && $winner)
                            <div class="mt-4 text-lg font-semibold text-green-600">
                                Winnaar: {{ $winner->name }}
                            </div>
                        @elseif($result === 'draw')
                            <div class="mt-4 text-lg font-semibold text-gray-600">
                                Gelijkspel
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
