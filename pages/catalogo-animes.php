<?php
// con esto conectamos la base de datos a la pagina principal
require_once __DIR__ . '/../includes/conexion.php';
require_once __DIR__ . '/../includes/session.php';

// Recogemos los get de los filtros y construimos la url de jikan
$nombre = $_GET['nombre'] ?? '';
$genero = $_GET['genero'] ?? '';
$estado = $_GET['estado'] ?? '';
$año = $_GET['anio'] ?? '';
$orden = $_GET['orden'] ?? '';
$formato = $_GET['formato'] ?? '';
$pagina = $_GET['pagina'] ?? 1;


// construimos la url de jikan apartir de la base
$jikan_url = "https://api.jikan.moe/v4/anime?limit=25&sfw=true&";
// añadimos los filtros a la url
if ($nombre) $jikan_url .= "q=" . urlencode($nombre) . "&";
if ($genero) $jikan_url .= "genres=" . urlencode($genero) . "&";
if ($estado) {
    $jikan_url .= "status=" . urlencode($estado) . "&";
} else {
    $jikan_url .= "status=airing&";
}
if ($año) $jikan_url .= "year=" . urlencode($año) . "&";
if ($orden) $jikan_url .= "order_by=" . urlencode($orden) . "&sort=desc&";
if ($formato) $jikan_url .= "type=" . urlencode($formato) . "&";
if ($pagina) $jikan_url .= "page=" . urlencode($pagina) . "&";

// llamamos a Jikan 
// Le ponemos la @ para ocultar el warning si Jikan se cae
$respuesta = @file_get_contents($jikan_url);
// Comprobamos si hay respuesta antes de decodificar
$datos = $respuesta ? json_decode($respuesta, true) : [];
$animes_emision = $datos['data'] ?? [];
// var_dump($animes_emision);

// eliminamos los animes duplicados que a veces nos devuelve jikan
$vistos = [];
$animes_sin_duplicados = [];
foreach ($animes_emision as $anime) {
    if (!in_array($anime['mal_id'], $vistos)) {
        $vistos[] = $anime['mal_id'];
        $animes_sin_duplicados[] = $anime;
    }
}
$animes_emision = $animes_sin_duplicados;

// obtenemos los generos para el filtro 
$respuesta_generos = file_get_contents('https://api.jikan.moe/v4/genres/anime');
$datos_generos = json_decode($respuesta_generos, true);
$generos = $datos_generos['data'];
// var_dump($generos);

//obtenemos la paginacion para msotrar los botones de siguiente y anterior
$paginacion = $datos['pagination'] ?? [];
$ultima_pagina = $paginacion['last_visible_page'] ?? 1;
$hay_siguiente = $paginacion['has_next_page'] ?? false;



// cargamos el header y el navbar en la pagina principal
include __DIR__ . '/../includes/header.php';
?>

<main>
    <h1>Catálogo de Animes</h1>
        <form action="" method="get">
            <div class="filtros">
                <label class="chip" for="nombre">Nombre:</label>
                <input class="filtro-btn" name="nombre" type="text" placeholder="Buscar por nombre...">
                <select name="genero"class="filtro-btn" data-filtro="genero">
                    <option value="">--Genero--</option>
                    <?php foreach ($generos as $genero): ?>
                    <option value="<?= $genero['mal_id'] ?>"><?= $genero['name'] ?></option>
                    <?php endforeach; ?>
                </select>
                <select name="estado"class="filtro-btn" data-filtro="estado">
                    <option value="">--Estado--</option>
                    <option value="airing">En emision</option>
                    <option value="complete">Finalizado</option>
                    <option value="upcoming">Proximamente</option>
                </select>
                <select class="filtro-btn" id="anio" name="anio">
                <option value="">Seleccionar año</option>
                <?php for ($year = date('Y'); $year >= 1980; $year--): ?>
                    <option value="<?= $year ?>"><?= $year ?></option>
                <?php endfor; ?>
                </select>
                <select name="orden" class="filtro-btn" data-filtro="orden">
                    <option value="start_date">Recientemente actualizados</option>
                    <option value="popularity">Populares</option>
                    <option value="title">Nombre A-Z</option>
                    <option value="score">Calificacion</option>
                </select>
                <select name="formato" class="filtro-btn" data-filtro="formato">
                    <option value="">--Formato--</option>
                    <option value="tv">serie</option>
                    <option value="movie">pelicula</option>
                    <option value="ova">ova</option>
                    <option value="special">especial</option>
                </select>
                <button type="submit" class="filtro-btn">Filtrar</button>
            </div>
            <div class="grid-lista">
            <?php foreach ($animes_emision as $anime): ?>
                <div class="card-lista" data-tipo="<?= $anime['type'] ?>" data-estado="<?= $anime['status'] ?>">
                    <a href="/mywatchlist/pages/detalle.php?id=<?= $anime['mal_id'] ?>&tipo=anime">
                        <img src="<?= $anime['images']['jpg']['large_image_url'] ?>" alt="">
                    </a>
                    <h3><?= $anime['title'] ?></h3>
                    <p>Estado: <?= $anime['status'] ?></p>
                    <p>Capitulos: <?= $anime['episodes'] ?></p>
                </div>
            <?php endforeach; ?>
            </div>
            <div class="filtros">
                <button name="pagina" value="<?= max(1, $pagina - 1) ?>" class="filtro-btn" <?= $pagina <= 1 ? 'disabled' : '' ?>>← Anterior</button>
                <button name="pagina" value="<?= $pagina + 1 ?>" class="filtro-btn" <?= !$hay_siguiente ? 'disabled' : '' ?>>Siguiente →</button>
            </div>
        </form>
</main>

<?php
// cargamos el footer
include __DIR__ . '/../includes/footer.php';
?>