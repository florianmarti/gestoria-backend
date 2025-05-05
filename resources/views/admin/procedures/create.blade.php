<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Crear Nuevo Trámite") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.procedures.store') }}">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">{{ __("Nombre") }}</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            @error('name')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="category" class="block text-sm font-medium text-gray-700">{{ __("Categoría") }}</label>
                            <select name="category" id="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="">{{ __("Selecciona una categoría") }}</option>
                                <option value="Vehiculos">{{ __("Vehículos") }}</option>
                                <option value="Impositivo">{{ __("Impositivo") }}</option>
                                <option value="Otros">{{ __("Otros") }}</option>
                            </select>
                            @error('category')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="fee" class="block text-sm font-medium text-gray-700">{{ __("Honorarios") }}</label>
                            <input type="number" step="0.01" name="fee" id="fee" value="{{ old('fee') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            @error('fee')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="estimated_days" class="block text-sm font-medium text-gray-700">{{ __("Días Estimados") }}</label>
                            <input type="number" name="estimated_days" id="estimated_days" value="{{ old('estimated_days') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            @error('estimated_days')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">{{ __("Descripción") }}</label>
                            <textarea name="description" id="description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">{{ __("Requisitos") }}</label>
                            @foreach ($requirements as $requirement)
                                <div class="flex items-center mb-2">
                                    <input type="checkbox" name="requirements[]" value="{{ $requirement->id }}" id="requirement_{{ $requirement->id }}" class="mr-2 leading-tight">
                                    <label for="requirement_{{ $requirement->id }}">{{ $requirement->name }} ({{ $requirement->type }})</label>
                                </div>
                            @endforeach
                            @error('requirements')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex items-center justify-end">
                            <a href="{{ route('admin.procedures.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded mr-2 hover:bg-gray-600 transition">
                                {{ __("Cancelar") }}
                            </a>
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                                {{ __("Crear Trámite") }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
