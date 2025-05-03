<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Iniciar Nuevo Trámite') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('procedures.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="procedure_id" class="block text-sm font-medium text-gray-700">{{ __('Seleccionar Trámite') }}</label>
                            <select name="procedure_id" id="procedure_id" class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white">
                                @foreach ($procedures as $procedure)
                                    <option value="{{ $procedure->id }}" {{ request('procedure_id') == $procedure->id ? 'selected' : '' }}>{{ $procedure->name }} - ${{ $procedure->fee }}</option>
                                @endforeach
                            </select>
                            @error('procedure_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">{{ __('Iniciar Trámite') }}</button>
                        <a href="{{ route('procedures.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">{{ __('Volver') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
