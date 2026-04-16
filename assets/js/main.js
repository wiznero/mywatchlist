



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
