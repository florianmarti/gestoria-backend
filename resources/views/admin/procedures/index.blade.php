<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Lista de Trámites") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session("success"))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                            {{ session("success") }}
                        </div>
                    @endif

                    <div class="mb-4">
                        <a href="{{ route("admin.procedures.create") }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                            {{ __("Crear Nuevo Trámite") }}
                        </a>
                    </div>

                    @if ($procedures->isEmpty())
                        <p>{{ __("No hay trámites disponibles.") }}</p>
                    @else
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __("Nombre") }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __("Categoría") }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __("Honorarios") }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __("Días Estimados") }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __("Acciones") }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($procedures as $procedure)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $procedure->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $procedure->category }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $procedure->fee }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $procedure->estimated_days }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ route("admin.procedures.edit", $procedure) }}" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 transition mr-2">
                                                {{ __("Editar") }}
                                            </a>
                                            <form action="{{ route("admin.procedures.destroy", $procedure) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method("DELETE")
                                                <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 transition" onclick="return confirm(\'¿Estás seguro de que deseas eliminar este trámite?\')">
                                                    {{ __("Eliminar") }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
