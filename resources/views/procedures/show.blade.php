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
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold">{{ $userProcedure->procedure->name }}</h3>
                        <p class="text-sm">Estado: {{ $userProcedure->status }}</p>
                        <p class="text-sm">Fecha de inicio: {{ $userProcedure->start_date->format('d/m/Y') }}</p>
                        @if ($userProcedure->end_date)
                            <p class="text-sm">Fecha de finalización: {{ $userProcedure->end_date->format('d/m/Y') }}</p>
                        @endif
                        <p class="text-sm">Honorarios: ${{ $userProcedure->procedure->fee }}</p>
                    </div>

                    <h3 class="text-lg font-semibold mb-4">{{ __('Documentos Subidos') }}</h3>
                    @if ($userProcedure->documents->isEmpty())
                        <p class="text-sm text-gray-600">{{ __('No se han subido documentos aún.') }}</p>
                    @else
                        <div class="grid grid-cols-1 gap-4">
                            @foreach ($userProcedure->documents as $document)
                                <div class="bg-white dark:bg-gray-800 p-4 rounded shadow">
                                    <p class="text-sm">Requisito: {{ $document->procedureRequirement->name }}</p>
                                    @if ($document->file_path)
                                        <a href="{{ Storage::url($document->file_path) }}" target="_blank" class="text-blue-500 underline">{{ __('Ver archivo') }}</a>
                                    @elseif ($document->value)
                                        <p class="text-sm">Valor: {{ $document->value }}</p>
                                    @endif
                                    <p class="text-sm">Estado: {{ $document->status }}</p>
                                    @if ($document->rejection_reason)
                                        <p class="text-sm text-red-500">Motivo de rechazo: {{ $document->rejection_reason }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="mt-4">
                        <a href="{{ route('documents.create', $userProcedure) }}" class="bg-blue-500 text-white px-4 py-2 rounded">{{ __('Subir Nuevo Documento') }}</a>
                        <a href="{{ route('procedures.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">{{ __('Volver a Trámites') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
