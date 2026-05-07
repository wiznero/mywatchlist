

document.addEventListener('DOMContentLoaded', function() {
    // JS para los inputs del progreso de detalle.php
    // Selector para la Calificación
    const inputCalificacion = document.getElementById('calificacion');
    const valorCalificacion = document.getElementById('calificacion-valor');

    if (inputCalificacion && valorCalificacion) {
        inputCalificacion.addEventListener('input', function() {
            valorCalificacion.innerText = this.value;
        });
    }

    // Selector para el Progreso
    const inputProgreso = document.getElementById('progreso');
    const valorProgreso = document.getElementById('progreso-valor');

    if (inputProgreso && valorProgreso) {
        inputProgreso.addEventListener('input', function() {
            valorProgreso.innerText = this.value;
        });
    }

    // JS para el menu hamburguesa
    const hamburguesa = document.getElementById('hamburguesa');
    const navMenu = document.querySelector('.nav-menu');

    hamburguesa.addEventListener('click', () => {
        navMenu.classList.toggle('activo');
    });
});


