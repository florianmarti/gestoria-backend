<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Trámites Disponibles') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('procedures.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-blue-600 transition">{{ __('Iniciar Nuevo Trámite') }}</a>
                    @if ($procedures->isEmpty())
                        <p class="text-sm text-gray-600">{{ __('No hay trámites disponibles.') }}</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach ($procedures as $procedure)
                                <div class="bg-white p-4 shadow-sm rounded-lg">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $procedure->name }}</h3>
                                    <p class="text-sm text-gray-600">{{ $procedure->description }}</p>
                                    <p class="text-sm text-gray-600">Categoría: {{ $procedure->category }}</p>
                                    <p class="text-sm text-gray-600">Honorarios: ${{ $procedure->fee }}</p>
                                    <p class="text-sm text-gray-600">Tiempo estimado: {{ $procedure->estimated_days }} días</p>
                                    <a href="{{ route('procedures.create') }}?procedure_id={{ $procedure->id }}" class="text-blue-500 underline">{{ __('Iniciar Trámite') }}</a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
