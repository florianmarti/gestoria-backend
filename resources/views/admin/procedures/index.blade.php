<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión de Trámites') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('admin.procedures.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">{{ __('Crear Nuevo Trámite') }}</a>
                    @if ($procedures->isEmpty())
                        <p class="text-sm text-gray-600">{{ __('No hay trámites creados.') }}</p>
                    @else
                        <div class="grid grid-cols-1 gap-4">
                            @foreach ($procedures as $procedure)
                                <div class="bg-white dark:bg-gray-800 p-4 rounded shadow">
                                    <h3 class="text-lg font-semibold">{{ $procedure->name }}</h3>
                                    <p class="text-sm">Categoría: {{ $procedure->category }}</p>
                                    <p class="text-sm">Honorarios: ${{ $procedure->fee }}</p>
                                    <p class="text-sm">Tiempo estimado: {{ $procedure->estimated_days }} días</p>
                                    <a href="{{ route('admin.procedures.edit', $procedure) }}" class="text-blue-500 underline">{{ __('Editar') }}</a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
