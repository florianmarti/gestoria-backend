<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Trámite') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.procedures.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Nombre') }}</label>
                            <input type="text" name="name" id="name" class="w-full p-2 border rounded" value="{{ old('name') }}">
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="category" class="block text-sm font-medium text-gray-700">{{ __('Categoría') }}</label>
                            <select name="category" id="category" class="w-full p-2 border rounded">
                                <option value="automotor">{{ __('Automotor') }}</option>
                                <option value="impositivo">{{ __('Impositivo') }}</option>
                                <option value="otros">{{ __('Otros') }}</option>
                            </select>
                            @error('category')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">{{ __('Descripción') }}</label>
                            <textarea name="description" id="description" class="w-full p-2 border rounded">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="fee" class="block text-sm font-medium text-gray-700">{{ __('Honorarios') }}</label>
                            <input type="number" name="fee" id="fee" step="0.01" class="w-full p-2 border rounded" value="{{ old('fee') }}">
                            @error('fee')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="estimated_days" class="block text-sm font-medium text-gray-700">{{ __('Días estimados') }}</label>
                            <input type="number" name="estimated_days" id="estimated_days" class="w-full p-2 border rounded" value="{{ old('estimated_days') }}">
                            @error('estimated_days')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">{{ __('Requisitos') }}</label>
                            @foreach ($requirements as $requirement)
                                <div class="flex items-center">
                                    <input type="checkbox" name="requirements[]" value="{{ $requirement->id }}" id="requirement_{{ $requirement->id }}" class="mr-2">
                                    <label for="requirement_{{ $requirement->id }}" class="text-sm">{{ $requirement->name }} ({{ $requirement->type === 'file' ? 'Archivo' : 'Texto' }})</label>
                                </div>
                            @endforeach
                            @error('requirements')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">{{ __('Crear Trámite') }}</button>
                        <a href="{{ route('admin.procedures.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">{{ __('Volver') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
