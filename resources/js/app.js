import './bootstrap';

import Alpine from 'alpinejs';




window.Alpine = Alpine;
Alpine.start();
document.getElementById('uploadForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData();
    const fileInput = document.getElementById('fileInput');
    formData.append('archivo', fileInput.files[0]);

    try {
        const response = await fetch('/api/subir-archivo', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        if (response.ok) {
            alert('Archivo subido con éxito');
        } else {
            alert('Error al subir el archivo');
        }
    } catch (error) {
        console.error('Error:', error);
    }
});
