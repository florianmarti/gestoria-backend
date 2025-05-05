<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Lista de Requisitos") }}
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
                        <a href="{{ route("admin.requirements.create") }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                            {{ __("Crear Nuevo Requisito") }}
                        </a>
                    </div>

                    @if ($requirements->isEmpty())
                        <p>{{ __("No hay requisitos disponibles.") }}</p>
                    @else
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __("Nombre") }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __("Tipo") }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __("Obligatorio") }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __("Acciones") }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($requirements as $requirement)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $requirement->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $requirement->type }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $requirement->is_required ? __("Sí") : __("No") }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ route("admin.requirements.edit", $requirement) }}" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 transition mr-2">
                                                {{ __("Editar") }}
                                            </a>
                                            <form action="{{ route("admin.requirements.destroy", $requirement) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method("DELETE")
                                                <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 transition" onclick="return confirm(\'¿Estás seguro de que deseas eliminar este requisito?\')">
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
