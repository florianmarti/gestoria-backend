<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Editar Trámite") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('procedures.update', $userProcedure) }}">
                        @csrf
                        @method("PATCH")
                        <div class="mb-4">
                            <label for="procedure_id" class="block text-sm font-medium text-gray-700">{{ __("Trámite") }}</label>
                            <select name="procedure_id" id="procedure_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="">{{ __("Selecciona un trámite") }}</option>
                                @foreach ($procedures as $procedure)
                                    <option value="{{ $procedure->id }}" {{ $userProcedure->procedure_id == $procedure->id ? 'selected' : '' }}>
                                        {{ $procedure->name }} ({{ $procedure->category }})
                                    </option>
                                @endforeach
                            </select>
                            @error("procedure_id")
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700">{{ __("Estado") }}</label>
                            <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="pending" {{ $userProcedure->status === 'pending' ? 'selected' : '' }}>{{ __("Pendiente") }}</option>
                                <option value="completed" {{ $userProcedure->status === 'completed' ? 'selected' : '' }}>{{ __("Completado") }}</option>
                            </select>
                            @error("status")
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex items-center justify-end">
                            <a href="{{ route('dashboard') }}" class="bg-gray-500 text-white px-4 py-2 rounded mr-2 hover:bg-gray-600 transition">
                                {{ __("Cancelar") }}
                            </a>
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                                {{ __("Actualizar") }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
