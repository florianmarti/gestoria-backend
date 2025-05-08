<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Documentos de tramites finalizados") }}
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
                        <p class="text-sm text-gray-600">{{ __("No hay documentos de trámites finalizados.") }}</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __("Usuario") }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __("Trámite") }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __("Requisito") }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __("Archivo") }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __("Estado") }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __("Motivo de Rechazo") }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __("Acciones") }}</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($documents as $document)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $document->userProcedure->user->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $document->userProcedure->procedure->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $document->requirement->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <a href="{{ Storage::url($document->file_path) }}" target="_blank" class="text-blue-600 hover:underline">
                                                    {{ __("Ver Archivo") }}
                                                </a>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                @if ($document->status === 'pending')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                        {{ __("Pendiente") }}
                                                    </span>
                                                @elseif ($document->status === 'approved')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        {{ __("Aprobado") }}
                                                    </span>
                                                @elseif ($document->status === 'rejected')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                        {{ __("Rechazado") }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $document->rejection_reason ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <div class="flex space-x-2">
                                                    @if ($document->status === 'pending')
                                                        <!-- Botón para aprobar -->
                                                        <form action="{{ route('admin.documents.approve', $document) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 transition">
                                                                {{ __("Aprobar") }}
                                                            </button>
                                                        </form>

                                                        <!-- Botón para rechazar con formulario para motivo -->
                                                        <div x-data="{ open: false }" class="inline">
                                                            <button @click="open = !open" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">
                                                                {{ __("Rechazar") }}
                                                            </button>
                                                            <div x-show="open" class="mt-2 p-4 bg-gray-100 rounded shadow-lg">
                                                                <form action="{{ route('admin.documents.reject', $document) }}" method="POST">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <div class="mb-2">
                                                                        <label for="rejection_reason" class="block text-sm font-medium text-gray-700">
                                                                            {{ __("Motivo de Rechazo") }}
                                                                        </label>
                                                                        <textarea name="rejection_reason" id="rejection_reason" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required></textarea>
                                                                        @error("rejection_reason")
                                                                            <span class="text-red-600 text-sm">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="flex justify-end space-x-2">
                                                                        <button type="button" @click="open = false" class="bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-600 transition">
                                                                            {{ __("Cancelar") }}
                                                                        </button>
                                                                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">
                                                                            {{ __("Confirmar Rechazo") }}
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    <!-- Botón para eliminar -->
                                                    <form action="{{ route('admin.documents.destroy', $document) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">
                                                            {{ __("Eliminar") }}
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
