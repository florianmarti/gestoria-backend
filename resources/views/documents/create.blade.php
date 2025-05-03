<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Subir Documento para ') . $userProcedure->procedure->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('documents.store', $userProcedure) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="requirement_id" class="block text-sm font-medium text-gray-700">{{ __('Seleccionar Requisito') }}</label>
                            <select name="requirement_id" id="requirement_id" class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white" onchange="updateFilePond(this)">
                                @foreach ($requirements as $requirement)
                                    @if (!$existingDocuments->has($requirement->id))
                                        <option value="{{ $requirement->id }}" data-type="{{ $requirement->type }}">{{ $requirement->name }} ({{ $requirement->type === 'file' ? 'Archivo' : 'Texto' }})</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('requirement_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4" id="file_input" style="display: none;">
                            <label for="file" class="block text-sm font-medium text-gray-700">{{ __('Archivo (PDF, JPG, PNG)') }}</label>
                            <input type="file" name="file" id="file" class="filepond">
                            @error('file')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4" id="text_input" style="display: none;">
                            <label for="value" class="block text-sm font-medium text-gray-700">{{ __('Valor') }}</label>
                            <input type="text" name="value" id="value" class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white">
                            @error('value')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">{{ __('Subir Documento') }}</button>
                        <a href="{{ route('procedures.show', $userProcedure) }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">{{ __('Volver') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- FilePond JS -->
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.min.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
    <script>
        FilePond.registerPlugin(FilePondPluginFileValidateType, FilePondPluginImagePreview);
        const inputElement = document.querySelector('input[type="file"]');
        const pond = FilePond.create(inputElement, {
            labelIdle: 'Arrastra y suelta tu archivo o <span class="filepond--label-action">Selecciona</span>',
            acceptedFileTypes: ['application/pdf', 'image/jpeg', 'image/png'],
            maxFileSize: '2MB',
            allowMultiple: false,
            instantUpload: false,
            imagePreviewHeight: 100,
        });

        function updateFilePond(select) {
            const fileInput = document.getElementById('file_input');
            const textInput = document.getElementById('text_input');
            const type = select.options[select.selectedIndex].dataset.type;
            fileInput.style.display = type === 'file' ? 'block' : 'none';
            textInput.style.display = type === 'text' ? 'block' : 'none';
        }

        document.addEventListener('DOMContentLoaded', () => {
            const select = document.getElementById('requirement_id');
            if (select.options.length > 0) {
                updateFilePond(select);
            }
        });
    </script>
</x-app-layout>
