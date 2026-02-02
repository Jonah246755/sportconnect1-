<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nieuw Team
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('teams.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Naam *</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 @error('name') border-red-500 @enderror" required>
                            @error('name')<p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="mb-4">
                            <label for="sport_id" class="block text-gray-700 text-sm font-bold mb-2">Sport *</label>
                            <select name="sport_id" id="sport_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 @error('sport_id') border-red-500 @enderror" required>
                                <option value="">Selecteer een sport</option>
                                @foreach($sports as $sport)
                                    <option value="{{ $sport->id }}" {{ old('sport_id') == $sport->id ? 'selected' : '' }}>{{ $sport->name }}</option>
                                @endforeach
                            </select>
                            @error('sport_id')<p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="mb-4">
                            <label for="age_group" class="block text-gray-700 text-sm font-bold mb-2">Leeftijdsgroep</label>
                            <input type="text" name="age_group" id="age_group" value="{{ old('age_group') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 @error('age_group') border-red-500 @enderror" placeholder="bijv. U15, Senioren">
                            @error('age_group')<p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Beschrijving</label>
                            <textarea name="description" id="description" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                            @error('description')<p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <a href="{{ route('teams.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Annuleren</a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Opslaan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
