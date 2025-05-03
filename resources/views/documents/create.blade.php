<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Subir Documento') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form id="document-upload-form" action="{{ route('documents.store', $userProcedure) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="requirement_id" class="block text-sm font-medium text-gray-700">{{ __('Requisito') }}</label>
                            <select name="requirement_id" id="requirement_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="">{{ __('Selecciona un requisito') }}</option>
                                @foreach ($requirements as $requirement)
                                    @if ($requirement->type === 'file' && !isset($existingDocuments[$requirement->id]))
                                        <option value="{{ $requirement->id }}">{{ $requirement->name }} ({{ $requirement->type === 'file' ? 'Archivo' : 'Texto' }})</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('requirement_id')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="dropzone" class="block text-sm font-medium text-gray-700">{{ __('Seleccionar archivos') }}</label>
                            <div id="dropzone" class="dropzone mt-1 border-2 border-dashed border-gray-300 rounded-md p-6 text-center">
                                <div class="dz-message">
                                    <p class="text-gray-500">{{ __('Arrastra y suelta archivos aquí o haz clic para seleccionar') }}</p>
                                </div>
                            </div>
                            @error('file')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                            {{ __('Subir Documento') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script type="module">
            import Dropzone from 'dropzone';

            const dropzone = new Dropzone('#dropzone', {
                url: "{{ route('documents.store', $userProcedure) }}",
                autoProcessQueue: false,
                uploadMultiple: true,
                maxFilesize: 2,
                acceptedFiles: '.pdf,.jpg,.jpeg,.png',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                paramName: 'file',
                init: function () {
                    const form = document.getElementById('document-upload-form');
                    const submitButton = form.querySelector('button[type="submit"]');
                    const requirementInput = document.getElementById('requirement_id');

                    this.on('sendingmultiple', function (data, xhr, formData) {
                        formData.append('requirement_id', requirementInput.value);
                    });

                    form.addEventListener('submit', (e) => {
                        e.preventDefault();
                        if (this.getQueuedFiles().length > 0 && requirementInput.value) {
                            this.processQueue();
                        } else {
                            alert('Por favor, selecciona un requisito y al menos un archivo.');
                        }
                    });

                    this.on('successmultiple', function (files, response) {
                        window.location.href = "{{ route('procedures.show', $userProcedure) }}";
                    });

                    this.on('errormultiple', function (files, response) {
                        alert('Error al subir los archivos: ' + (response.message || 'Intenta de nuevo.'));
                    });
                }
            });
        </script>
    @endpush
</x-app-layout>
