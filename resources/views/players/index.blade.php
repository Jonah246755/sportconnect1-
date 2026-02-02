<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Spelers</h2>
            <a href="{{ route('players.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Nieuwe Speler</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($players->isEmpty())
                        <p class="text-gray-500">Nog geen spelers toegevoegd.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Naam</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Team</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Positie</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rugnummer</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acties</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($players as $player)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $player->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $player->team->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $player->position ?? '-' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $player->jersey_number ?? '-' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                @if($player->isInjured())
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Geblesseerd</span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Fit</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                                <a href="{{ route('players.show', $player) }}" class="text-blue-600 hover:text-blue-900">Bekijken</a>
                                                <a href="{{ route('players.edit', $player) }}" class="text-yellow-600 hover:text-yellow-900">Bewerken</a>
                                                <form action="{{ route('players.destroy', $player) }}" method="POST" class="inline" onsubmit="return confirm('Weet je zeker dat je deze speler wilt verwijderen?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Verwijderen</button>
                                                </form>
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
