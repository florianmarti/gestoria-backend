<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Iniciar Nuevo Trámite') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('procedures.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="procedure_id" class="block text-sm font-medium text-gray-700">Selecciona un trámite:</label>
                            <select name="procedure_id" id="procedure_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                @foreach ($procedures as $procedure)
                                    <option value="{{ $procedure->id }}">{{ $procedure->name }} - ${{ $procedure->fee }}</option>
                                @endforeach
                            </select>
                            @error('procedure_id')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">{{ __('Iniciar Trámite') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
