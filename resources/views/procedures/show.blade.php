<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalles del Trámite') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold text-gray-900">{{ $userProcedure->procedure->name }}</h3>
                    <p class="text-sm text-gray-600"><strong>{{ __('Estado') }}:</strong> {{ $userProcedure->status }}</p>
                    <p class="text-sm text-gray-600"><strong>{{ __('Fecha de Inicio') }}:</strong> {{ $userProcedure->start_date->format('d/m/Y') }}</p>
                    <div class="mt-4 flex space-x-4">
                        @if (auth()->user()->role === 'client')
                            <a href="{{ route('documents.create', $userProcedure) }}" class="text-blue-500 underline hover:text-blue-600 transition">{{ __('Subir Documentos') }}</a>
                        @endif
                        <a href="{{ route('procedures.index') }}" class="text-blue-500 underline hover:text-blue-600 transition">{{ __('Volver') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
