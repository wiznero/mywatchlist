<?php
// con esto conectamos la base de datos a la pagina principal
require_once 'includes/conexion.php';
// cargamos el header y el navbar en la pagina principal
include 'includes/header.php';
?>

<?php
// llamamos a Jikan para traer el top de animes
$respuesta = file_get_contents('https://api.jikan.moe/v4/top/anime?limit=6');
$datos = json_decode($respuesta, true);
$top_animes = $datos['data'];
// llamamos a Jikan para traer el top de Mangas
$respuesta_manga = file_get_contents('https://api.jikan.moe/v4/top/manga?limit=6');
$datos_manga = json_decode($respuesta_manga, true);
$top_mangas = $datos_manga['data'];

?>


<main>
    <section class="hero">
        <div class="texto-hero">
            <?php if (isset($_SESSION['usuario_nombre'])): ?>
                <h2>Bienvenido, <?= $_SESSION['usuario_nombre'] ?></h2>
            <?php else: ?>
                <h2>Tu mundo anime, organizado</h2>
            <?php endif; ?>
            <p>Lleva el control de tu anime y manga favorito</p>
            <div class="hero-botones">
                <a href="/mywatchlist/pages/catalogo-animes.php" class="btn-primary">Explorar</a>
                <?php if (!isset($_SESSION['usuario_id'])): ?>
                    <a href="/mywatchlist/pages/registro.php" class="btn-secondary">Crear cuenta</a>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <hr>
    <section class="top"> 
        <!-- SECCION TOP ANIMES -->
        <div class="banner">
            <div class="slider" style="--quantity: <?= count($top_animes) ?>">
                <?php foreach ($top_animes as $indice => $anime): ?>
                    <div class="item" style="--position: <?= $indice + 1?>">
                        <a href="/mywatchlist/pages/detalle.php?id=<?= $anime['mal_id'] ?>&tipo=anime">
                        <img src="<?= $anime['images']['jpg']['large_image_url'] ?>" alt="">
                        </a>
                        <div class="content">
                            <p><?= $anime['title'] ?></p>
                            <p><?= $anime['score'] ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="text-content">
                <h2>TOP ANIMES: </h2>
            </div>
        </div>
        <!-- version movil top animes - se oculta en escritorio -->
        <div class="top-movil">
            <?php foreach ($top_animes as $anime): ?>
                <a href="/mywatchlist/pages/detalle.php?id=<?= $anime['mal_id'] ?>&tipo=anime" class="card-movil">
                    <img src="<?= $anime['images']['jpg']['large_image_url'] ?>" alt="<?= $anime['title'] ?>">
                    <p><?= $anime['title'] ?></p>
                    <p><?= $anime['score'] ?></p>
                </a>
            <?php endforeach; ?>
        </div>
        <!-- SECCION TOP MANGAS -->
        <div class="banner">
            <div class="slider" style="--quantity: <?= count($top_mangas) ?>">
                <?php foreach ($top_mangas as $indice => $manga): ?>
                    <div class="item" style="--position: <?= $indice + 1?>">
                        <a href="/mywatchlist/pages/detalle.php?id=<?= $manga['mal_id'] ?>&tipo=manga">
                        <img src="<?= $manga['images']['jpg']['large_image_url'] ?>" alt="">
                        </a>
                        <div class="content">
                            <p><?= $manga['title'] ?></p>
                            <p><?= $manga['score'] ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="text-content">
                <h2>TOP MANGAS: </h2>
            </div>
        </div>
        <!-- version movil top animes - se oculta en escritorio -->
        <div class="top-movil">
            <?php foreach ($top_animes as $anime): ?>
                <a href="/mywatchlist/pages/detalle.php?id=<?= $anime['mal_id'] ?>&tipo=anime" class="card-movil">
                    <img src="<?= $anime['images']['jpg']['large_image_url'] ?>" alt="<?= $anime['title'] ?>">
                    <p><?= $anime['title'] ?></p>
                    <p><?= $anime['score'] ?></p>
                </a>
            <?php endforeach; ?>

    </section>
</main>

<?php
// cargamos el footer
include 'includes/footer.php';
?>