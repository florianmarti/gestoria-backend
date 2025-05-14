<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Administrar Trámites') }}
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

                    <h3 class="text-lg font-semibold mb-4">{{ __('Lista de Trámites') }}</h3>
                    <div class="mb-4">
                        <a href="{{ route('admin.procedures.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            {{ __('Crear Nuevo Trámite') }}
                        </a>
                    </div>

                    @if ($procedures->isEmpty())
                        <p class="text-sm text-gray-600">{{ __('No hay trámites disponibles.') }}</p>
                    @else
                        <div class="grid grid-cols-1 gap-4">
                            @foreach ($procedures as $procedure)
                                <div class="p-4 border rounded shadow-sm">
                                    <h4 class="text-md font-semibold">{{ $procedure->name }}</h4>
                                    <p class="text-sm text-gray-600">Categoría: {{ $procedure->category }}</p>
                                    <p class="text-sm text-gray-600">Honorarios: ${{ number_format($procedure->fee, 2) }}</p>
                                    <p class="text-sm text-gray-600">Tiempo estimado: {{ $procedure->estimated_days }} días</p>
                                    <p class="text-sm text-gray-600">{{ $procedure->description }}</p>
                                    <div class="flex items-center justify-end space-x-2 mt-2">
                                        <a href="{{ route('admin.procedures.edit', $procedure) }}" class="text-blue-500 hover:underline">{{ __('Editar') }}</a>
                                        <form action="{{ route('admin.procedures.destroy', $procedure) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('¿Estás seguro de eliminar este trámite?');">{{ __('Eliminar') }}</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4">
                            {{ $procedures->links() }}
                        </div>
                    @endif

                    <h3 class="text-lg font-semibold mb-4 mt-8">{{ __('Trámites Iniciados por Usuarios') }}</h3>
                    @if ($userProcedures->isEmpty())
                        <p class="text-sm text-gray-600">{{ __('No hay trámites iniciados.') }}</p>
                    @else
                        <div class="grid grid-cols-1 gap-4">
                            @foreach ($userProcedures as $userProcedure)
                                <div class="p-4 border rounded shadow-sm">
                                    <h4 class="text-md font-semibold">{{ $userProcedure->procedure->name }}</h4>
                                    <p class="text-sm text-gray-600">Usuario: {{ $userProcedure->user->name }}</p>
                                    <p class="text-sm text-gray-600">Estado: {{ $userProcedure->status }}</p>
                                    <p class="text-sm text-gray-600">Fecha de inicio: {{ $userProcedure->start_date->format('d/m/Y') }}</p>
                                    @if ($userProcedure->documents->isNotEmpty())
                                        <a href="{{ route('admin.procedures.documents', $userProcedure) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mt-2 inline-block">
                                            {{ __('Revisar Documentos') }}
                                        </a>
                                    @endif
                                    @if ($userProcedure->status !== 'completed')
                                        <form action="{{ route('admin.procedures.complete', $userProcedure) }}" method="POST" class="mt-2 inline-block">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">{{ __('Marcar como Completado') }}</button>
                                        </form>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4">
                            {{ $userProcedures->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
