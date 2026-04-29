// JS para mi_lista.php ----------------------------------------------------------------------------------------------------------------
document.addEventListener('DOMContentLoaded', () => {
    // traemos todos los botones de filtro
    const botones = document.querySelectorAll('.filtro-btn');

    // traemos todas las cards
    const cards = document.querySelectorAll('.card-lista');

    botones.forEach(boton => {
        boton.addEventListener('click', () => {
            // obtenemos el filtro del boton
            console.log('Botón pulsado:', boton.dataset.filtro);
            const filtro = boton.dataset.filtro;
            // recorremos las cards
            cards.forEach(card => {
                // aqui decidimos si mostramos o no la card dependiendo del filtro
                if (filtro === 'todos' || card.dataset.estado === filtro || card.dataset.tipo === filtro) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
});