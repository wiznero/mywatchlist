<?php
// con esto conectamos la base de datos a la pagina principal
require_once __DIR__ . '/../includes/conexion.php';
require_once __DIR__ . '/../includes/session.php';


// llamamos a Jikan 
$respuesta = file_get_contents("https://api.jikan.moe/v4/anime?status=airing&order_by=score&sort=desc&limit=20");
$datos = json_decode($respuesta, true);
$animes_emision = $datos['data'];

// var_dump($animes_emision);

// cargamos el header y el navbar en la pagina principal
include __DIR__ . '/../includes/header.php';
?>

<main>
    <h1>Catalogo de Animes</h1>

        <div class="filtros">
            <label for="buscar">Buscar:</label>
            <input type="text">
            <button type="button" class="filtro-btn" data-filtro="genero">Genero</button>
            <button type="button" class="filtro-btn" data-filtro="estado">Estado</button>
            <button type="button" class="filtro-btn" data-filtro="ano">Año</button>
            <select type="button" class="filtro-btn" data-filtro="orden" placeholder="Orden por">
                <option value="">Recientemente actualizados</option>
                <option value="">Recientemente añadidos</option>
                <option value="">Nombre A-Z</option>
                <option value="">Calificacion</option>
            </select>
            <select type="button" class="filtro-btn" data-filtro="formato" placeholder="Formato">
                <option value="">serie</option>
                <option value="">pelicula</option>
                <option value="">ova</option>
                <option value="">especial</option>
            </select>
        </div>
        <div class="grid-lista">
        <?php foreach ($animes_emision as $anime): ?>
            <div class="card-lista" data-tipo="<?= $anime['type'] ?>" data-estado="<?= $anime['status'] ?>">
                <a href="/mywatchlist/pages/detalle.php?id=<?= $anime['mal_id'] ?>&tipo=anime">
                    <img src="<?= $anime['images']['jpg']['large_image_url'] ?>" alt="">
                </a>
                <h3><?= $anime['title'] ?></h3>
                <p>Estado: <?= $anime['status'] ?></p>
                <p>Progreso: <?= $anime['episodes'] ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php
// cargamos el footer
include __DIR__ . '/../includes/footer.php';
?>