<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Trainingen</h2>
            <a href="{{ route('trainings.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Nieuwe Training</a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($trainings->isEmpty())
                        <p class="text-gray-500">Nog geen trainingen gepland.</p>
                    @else
                        <div class="space-y-4">
                            @foreach($trainings as $training)
                                <div class="border rounded-lg p-4">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="font-semibold text-lg">{{ $training->team->name }}</h3>
                                            <p class="text-sm text-gray-600">{{ $training->scheduled_at->format('d-m-Y H:i') }}</p>
                                            @if($training->location)
                                                <p class="text-sm text-gray-500">{{ $training->location }}</p>
                                            @endif
                                        </div>
                                        <div class="text-right space-x-2">
                                            <a href="{{ route('trainings.show', $training) }}" class="text-blue-600 hover:text-blue-900">Bekijken</a>
                                            <a href="{{ route('trainings.edit', $training) }}" class="text-yellow-600 hover:text-yellow-900">Bewerken</a>
                                            <form action="{{ route('trainings.destroy', $training) }}" method="POST" class="inline">
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
