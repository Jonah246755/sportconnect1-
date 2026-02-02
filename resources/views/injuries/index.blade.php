<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Blessures</h2>
            <a href="{{ route('injuries.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Nieuwe Blessure</a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($injuries->isEmpty())
                        <p class="text-gray-500">Geen blessures geregistreerd.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Speler</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Team</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Datum</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acties</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($injuries as $injury)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <a href="{{ route('players.show', $injury->player) }}" class="text-blue-600">{{ $injury->player->name }}</a>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $injury->player->team->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $injury->type }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $injury->injury_date->format('d-m-Y') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $injury->status === 'recovered' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ ucfirst($injury->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                                <a href="{{ route('injuries.show', $injury) }}" class="text-blue-600 hover:text-blue-900">Bekijken</a>
                                                <a href="{{ route('injuries.edit', $injury) }}" class="text-yellow-600 hover:text-yellow-900">Bewerken</a>
                                                <form action="{{ route('injuries.destroy', $injury) }}" method="POST" class="inline">
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
