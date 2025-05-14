<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Subir Documentos") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route("documents.store", $userProcedure) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="file" class="block text-sm font-medium text-gray-700">{{ __("Documento") }}</label>
                            <input type="file" name="file" id="file" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            @error("file")
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex items-center justify-end">
                            <a href="{{ route('procedures.show', $userProcedure) }}" class="bg-gray-500 text-white px-4 py-2 rounded mr-2 hover:bg-gray-600 transition">
                                {{ __("Cancelar") }}
                            </a>
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                                {{ __("Subir Documento") }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
