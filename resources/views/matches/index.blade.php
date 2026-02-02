<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Wedstrijden</h2>
            <a href="{{ route('matches.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Nieuwe Wedstrijd</a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($matches->isEmpty())
                        <p class="text-gray-500">Nog geen wedstrijden gepland.</p>
                    @else
                        <div class="space-y-4">
                            @foreach($matches as $match)
                                <div class="border rounded-lg p-4">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="font-semibold text-lg">{{ $match->homeTeam->name }} vs {{ $match->awayTeam->name }}</h3>
                                            <p class="text-sm text-gray-600">{{ $match->scheduled_at->format('d-m-Y H:i') }}</p>
                                            @if($match->status === 'completed')
                                                <p class="text-lg font-bold mt-2">{{ $match->home_score }} - {{ $match->away_score }}</p>
                                            @else
                                                <span class="inline-block px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-800 mt-2">{{ ucfirst($match->status) }}</span>
                                            @endif
                                        </div>
                                        <div class="text-right space-x-2">
                                            <a href="{{ route('matches.show', $match) }}" class="text-blue-600 hover:text-blue-900">Bekijken</a>
                                            <a href="{{ route('matches.edit', $match) }}" class="text-yellow-600 hover:text-yellow-900">Bewerken</a>
                                            <form action="{{ route('matches.destroy', $match) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Verwijderen</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
