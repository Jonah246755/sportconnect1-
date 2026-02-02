<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Sporten
            </h2>
            <a href="{{ route('sports.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Nieuwe Sport
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($sports->isEmpty())
                        <p class="text-gray-500">Nog geen sporten toegevoegd.</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($sports as $sport)
                                <div class="border rounded-lg p-4 hover:shadow-lg transition">
                                    <h3 class="text-lg font-semibold mb-2">{{ $sport->name }}</h3>
                                    @if($sport->description)
                                        <p class="text-gray-600 text-sm mb-3">{{ Str::limit($sport->description, 100) }}</p>
                                    @endif
                                    <div class="text-sm text-gray-500 mb-4">
                                        {{ $sport->teams_count }} {{ $sport->teams_count === 1 ? 'team' : 'teams' }}
                                    </div>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('sports.show', $sport) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                            Bekijken
                                        </a>
                                        <a href="{{ route('sports.edit', $sport) }}" class="text-yellow-600 hover:text-yellow-800 text-sm">
                                            Bewerken
                                        </a>
                                        <form action="{{ route('sports.destroy', $sport) }}" method="POST" class="inline" onsubmit="return confirm('Weet je zeker dat je deze sport wilt verwijderen?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                                Verwijderen
                                            </button>
                                        </form>
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
