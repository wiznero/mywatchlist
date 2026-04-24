



// JS para la barra de busqueda
let search = document.querySelector('.search');
let cerrar = document.querySelector('.close');
let searchBox = document.querySelector('.searchBox');
search.onclick = function () {
    searchBox.classList.add('active');
}
cerrar.onclick = function () {
    searchBox.classList.remove('active'); 
}

// JS para los inputs del progreso de detalle.php
document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Selector para la Calificación
    const inputCalificacion = document.getElementById('calificacion');
    const valorCalificacion = document.getElementById('calificacion-valor');

    if (inputCalificacion && valorCalificacion) {
        inputCalificacion.addEventListener('input', function() {
            valorCalificacion.innerText = this.value;
        });
    }

    // 2. Selector para el Progreso
    const inputProgreso = document.getElementById('progreso');
    const valorProgreso = document.getElementById('progreso-valor');

    if (inputProgreso && valorProgreso) {
        inputProgreso.addEventListener('input', function() {
            valorProgreso.innerText = this.value;
        });
    }
});
