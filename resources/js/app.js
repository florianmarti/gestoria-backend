import './bootstrap';

import Alpine from 'alpinejs';
import FilePond from 'filepond';
import 'filepond/dist/filepond.min.css';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';

window.Alpine = Alpine;

Alpine.start();

// Registrar plugins
FilePond.registerPlugin(FilePondPluginImagePreview, FilePondPluginFileValidateType);
