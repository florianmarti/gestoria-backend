<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Subir Documentos - {{ $userProcedure->procedure->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Selector de Requisitos -->
                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-medium text-gray-700">
                            Seleccione el requisito a cumplir
                        </label>
                        <select id="requirementSelect" class="w-full p-2 border rounded">
                            @foreach($requirements as $requirement)
                                @if($requirement->type === 'file')
                                    <option value="{{ $requirement->id }}"
                                            data-uploaded="{{ $existingDocuments->has($requirement->id) ? 'true' : 'false' }}">
                                        {{ $requirement->name }}
                                        @if($existingDocuments->has($requirement->id))
                                            (Ya subido)
                                        @endif
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <!-- Dropzone Container -->
                    <div id="myDropzone" class="dropzone border-2 border-dashed border-gray-300 rounded-lg p-4">
                        @csrf
                        <input type="hidden" name="requirement_id" value="{{ $requirement->id }}">
                        <div class="dz-message text-center">
                            <h3 class="text-lg font-medium">Arrastra archivos aquí</h3>
                            <p class="text-sm text-gray-500">o haz clic para seleccionar</p>
                        </div>
                    </div>

                    <!-- Documentos Subidos -->
                    <div class="mt-8">
                        <h3 class="mb-4 text-lg font-medium">Documentos Subidos</h3>
                        <div id="uploadedFilesList" class="space-y-3">
                            @foreach($existingDocuments as $document)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                                    <div>
                                        <span class="font-medium">{{ $document->procedureRequirement->name }}</span>
                                        <a href="{{ Storage::url($document->file_path) }}"
                                           target="_blank"
                                           class="ml-2 text-sm text-blue-500 hover:underline">
                                            Ver documento
                                        </a>
                                    </div>
                                    <span class="px-2 py-1 text-sm rounded
                                              {{ $document->status === 'approved' ? 'bg-green-100 text-green-800' :
                                                 ($document->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                        {{ ucfirst($document->status) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('procedures.show', $userProcedure) }}"
                           class="bg-gray-500 text-white px-4 py-2 rounded">
                            Volver al trámite
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        /* Reset de estilos que podrían interferir */
        #documentDropzone * {
            pointer-events: all !important;
        }

        /* Estilos obligatorios para Dropzone */
        .dropzone {
            min-height: 200px;
            position: relative;
        }

        .dropzone.dz-clickable {
            cursor: pointer;
        }

        .dropzone.dz-clickable .dz-message,
        .dropzone.dz-clickable .dz-message span {
            cursor: pointer;
        }

        /* Asegurar visibilidad del mensaje */
        .dz-message {
            pointer-events: none;
            text-align: center;
        }
    </style>
    @endpush

    @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Deshabilitar auto-descubrimiento
        Dropzone.autoDiscover = false;

        // 2. Verificar si el elemento existe
        if (!document.getElementById("documentDropzone")) {
            console.error("El elemento Dropzone no existe en el DOM");
            return;
        }

        // 3. Configuración mínima para pruebas
        const myDropzone = new Dropzone("#documentDropzone", {
            url: "{{ route('documents.store', $userProcedure) }}",
            paramName: "file",
            clickable: true, // Asegurar que sea clickeable
            previewsContainer: false, // Desactivar previsualizaciones por ahora
            dictDefaultMessage: "Suelta aquí tus archivos",
            dictFallbackMessage: "Tu navegador no soporta arrastrar y soltar archivos",
            dictFileTooBig: "Archivo demasiado grande ({{ __('max: 2MB') }})",
            dictInvalidFileType: "No puedes subir archivos de este tipo",
            dictResponseError: "Error al subir archivo!",
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            init: function() {
                // Verificar inicialización
                console.log("Dropzone inicializado correctamente");

                this.on("addedfile", function(file) {
                    console.log("Archivo añadido:", file.name);
                });

                this.on("success", function(file, response) {
                    console.log("Respuesta del servidor:", response);
                });

                this.on("error", function(file, error) {
                    console.error("Error:", error);
                });
            }
        });

        // 4. Verificar eventos click manualmente
        document.getElementById('documentDropzone').addEventListener('click', function(e) {
            console.log("Click en Dropzone detectado");
        });

        // 5. Forzar cursor de mano
        document.getElementById('documentDropzone').style.cursor = "pointer";
    });
    </script>
    @endpush
</x-app-layout>
