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
$jikan_url = "https://api.jikan.moe/v4/manga?limit=25&sfw=true&";
// añadimos los filtros a la url
if ($nombre) $jikan_url .= "q=" . urlencode($nombre) . "&";
if ($genero) $jikan_url .= "genres=" . urlencode($genero) . "&";
if ($estado) {
    $jikan_url .= "status=" . urlencode($estado) . "&";
}
if ($año) $jikan_url .= "year=" . urlencode($año) . "&";
if ($orden) $jikan_url .= "order_by=" . urlencode($orden) . "&sort=desc&";
if ($formato) $jikan_url .= "type=" . urlencode($formato) . "&";
if ($pagina) $jikan_url .= "page=" . urlencode($pagina) . "&";

// llamamos a Jikan 
// Silenciamos el posible error de la API con la @
$respuesta = @file_get_contents($jikan_url);
// Si hay respuesta decodificamos, si no, array vacío
$datos = $respuesta ? json_decode($respuesta, true) : [];
$mangas_emision = $datos['data'] ?? [];
// var_dump($mangas_emision);

// eliminamos los mangas duplicados que a veces nos devuelve jikan
$vistos = [];
$mangas_sin_duplicados = [];
foreach ($mangas_emision as $manga) {
    if (!in_array($manga['mal_id'], $vistos)) {
        $vistos[] = $manga['mal_id'];
        $mangas_sin_duplicados[] = $manga;
    }
}
$mangas_emision = $mangas_sin_duplicados;

// obtenemos los generos para el filtro 
$respuesta_generos = file_get_contents('https://api.jikan.moe/v4/genres/manga');
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
    <h1>Catálogo de Mangas</h1>
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
                    <option value="publishing">En Publlicacion</option>
                    <option value="complete">Finalizado</option>
                    <option value="upcoming">Proximamente</option>
                    <option value="hiatus">En pausa</option>
                    <option value="discontinued">Abandonado</option>
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
                    <option value="manga">Manga</option>
                    <option value="novel">Novela</option>
                    <option value="lightnovel">Light Novel</option>
                    <option value="oneshot">One Shot</option>
                    <option value="doujin">Doujin</option>
                    <option value="manhwa">Manhwa</option>
                    <option value="manhua">Manhua</option>
                </select>
                <button type="submit" class="filtro-btn">Filtrar</button>
            </div>
            <div class="grid-lista">
            <?php foreach ($mangas_emision as $manga): ?>
                <div class="card-lista" data-tipo="<?= $manga['type'] ?>" data-estado="<?= $manga['status'] ?>">
                    <a href="/mywatchlist/pages/detalle.php?id=<?= $manga['mal_id'] ?>&tipo=manga">
                        <img src="<?= $manga['images']['jpg']['large_image_url'] ?>" alt="">
                    </a>
                    <h3><?= $manga['title'] ?></h3>
                    <p>Estado: <?= $manga['status'] ?></p>
                    <p>Capitulos: <?= $manga['chapters'] ?></p>
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