<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Blessure Details</h2>
            <div class="space-x-2">
                <a href="{{ route('injuries.edit', $injury) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Bewerken</a>
                <a href="{{ route('injuries.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Terug</a>
            </div>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div><dt class="text-sm font-medium text-gray-500">Speler</dt><dd class="mt-1 text-sm text-gray-900"><a href="{{ route('players.show', $injury->player) }}" class="text-blue-600">{{ $injury->player->name }}</a></dd></div>
                        <div><dt class="text-sm font-medium text-gray-500">Team</dt><dd class="mt-1 text-sm text-gray-900">{{ $injury->player->team->name }}</dd></div>
                        <div><dt class="text-sm font-medium text-gray-500">Type Blessure</dt><dd class="mt-1 text-sm text-gray-900 font-semibold">{{ $injury->type }}</dd></div>
                        <div><dt class="text-sm font-medium text-gray-500">Status</dt><dd class="mt-1"><span class="px-2 py-1 text-xs rounded {{ $injury->status === 'recovered' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">{{ ucfirst($injury->status) }}</span></dd></div>
                        <div><dt class="text-sm font-medium text-gray-500">Blessure Datum</dt><dd class="mt-1 text-sm text-gray-900">{{ $injury->injury_date->format('d-m-Y') }}</dd></div>
                        <div><dt class="text-sm font-medium text-gray-500">Duur</dt><dd class="mt-1 text-sm text-gray-900">{{ $durationInDays }} dagen</dd></div>
                        @if($injury->expected_recovery_date)
                            <div><dt class="text-sm font-medium text-gray-500">Verwacht Herstel</dt><dd class="mt-1 text-sm text-gray-900">{{ $injury->expected_recovery_date->format('d-m-Y') }} @if($isOverdue)<span class="text-red-600 font-semibold">(Achterstallig)</span>@endif</dd></div>
                        @endif
                        @if($injury->actual_recovery_date)
                            <div><dt class="text-sm font-medium text-gray-500">Werkelijk Herstel</dt><dd class="mt-1 text-sm text-gray-900">{{ $injury->actual_recovery_date->format('d-m-Y') }}</dd></div>
                        @endif
                        @if($injury->description)
                            <div class="col-span-2"><dt class="text-sm font-medium text-gray-500">Beschrijving</dt><dd class="mt-1 text-sm text-gray-900">{{ $injury->description }}</dd></div>
                        @endif
                    </dl>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
