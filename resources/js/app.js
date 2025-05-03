import './bootstrap';

import Alpine from 'alpinejs';
import Dropzone from 'dropzone';
import 'dropzone/dist/dropzone.css';

// Desactivar autoDiscover para evitar que Dropzone inicialice automáticamente
Dropzone.autoDiscover = false;

window.Alpine = Alpine;
Alpine.start();
