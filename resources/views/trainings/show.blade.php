<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Training - {{ $training->team->name }}</h2>
            <div class="space-x-2">
                <a href="{{ route('trainings.edit', $training) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Bewerken</a>
                <a href="{{ route('trainings.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Terug</a>
            </div>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Training Informatie</h3>
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div><dt class="text-sm font-medium text-gray-500">Team</dt><dd class="mt-1 text-sm text-gray-900">{{ $training->team->name }}</dd></div>
                        <div><dt class="text-sm font-medium text-gray-500">Datum & Tijd</dt><dd class="mt-1 text-sm text-gray-900">{{ $training->scheduled_at->format('d-m-Y H:i') }}</dd></div>
                        <div><dt class="text-sm font-medium text-gray-500">Locatie</dt><dd class="mt-1 text-sm text-gray-900">{{ $training->location ?? '-' }}</dd></div>
                        <div><dt class="text-sm font-medium text-gray-500">Opkomst</dt><dd class="mt-1 text-sm text-gray-900">{{ $attendancePercentage }}%</dd></div>
                        @if($training->notes)
                            <div class="col-span-2"><dt class="text-sm font-medium text-gray-500">Notities</dt><dd class="mt-1 text-sm text-gray-900">{{ $training->notes }}</dd></div>
                        @endif
                    </dl>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Aanwezigheid</h3>
                    <form action="{{ route('trainings.attendance', $training) }}" method="POST">
                        @csrf
                        <div class="space-y-2">
                            @foreach($training->attendances as $attendance)
                                <div class="flex items-center">
                                    <input type="checkbox" name="attendances[{{ $attendance->player_id }}]" value="1" {{ $attendance->attended ? 'checked' : '' }} class="mr-3">
                                    <label class="text-sm">{{ $attendance->player->name }}</label>
                                </div>
                            @endforeach
                        </div>
                        <button type="submit" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Opslaan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
