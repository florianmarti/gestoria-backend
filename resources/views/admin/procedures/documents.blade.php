<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Revisar Documentos - Trámite: ') . $userProcedure->procedure->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($documents->isEmpty())
                        <p class="text-sm text-gray-600">{{ __('No hay documentos asociados a este trámite.') }}</p>
                    @else
                        <div class="grid grid-cols-1 gap-4">
                            @foreach ($documents as $document)
                                <div class="p-4 border rounded shadow-sm">
                                    <p class="text-sm text-gray-600">Requisito: {{ $document->requirement->name }}</p>
                                    <p class="text-sm text-gray-600">Estado: {{ $document->status }}</p>
                                    <a href="{{ Storage::url($document->file_path) }}" target="_blank" class="text-blue-500 hover:underline">{{ __('Ver Documento') }}</a>
                                    @if ($document->status === 'pending')
                                        <form action="{{ route('admin.procedures.documents.approve', [$userProcedure, $document]) }}" method="POST" class="mt-2" style="display:inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">{{ __('Aprobar') }}</button>
                                        </form>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <div class="mt-4">
                        <a href="{{ route('admin.procedures.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                            {{ __('Volver') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
