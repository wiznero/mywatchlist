<?php
// con esto conectamos la base de datos a la pagina principal
require_once 'includes/conexion.php';
// cargamos el header y el navbar en la pagina principal
include 'includes/header.php';
?>

<?php
// llamamos a Jikan para traer el top de animes
$respuesta = @file_get_contents('https://api.jikan.moe/v4/top/anime?limit=6');
$top_animes = $respuesta ? (json_decode($respuesta, true)['data'] ?? []) : [];
// llamamos a Jikan para traer el top de Mangas
$respuesta_manga = @file_get_contents('https://api.jikan.moe/v4/top/manga?limit=6');
$top_mangas = $respuesta_manga ? (json_decode($respuesta_manga, true)['data'] ?? []) : [];

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
                <a href="/pages/catalogo-animes.php" class="btn-primary">Explorar</a>
                <?php if (!isset($_SESSION['usuario_id'])): ?>
                    <a href="/pages/registro.php" class="btn-secondary">Crear cuenta</a>
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
                        <a href="/pages/detalle.php?id=<?= $anime['mal_id'] ?>&tipo=anime">
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
        <h2 class="titulo-movil">TOP ANIMES</h2>
        <div class="top-movil">
            <?php foreach ($top_animes as $anime): ?>
                <a href="/pages/detalle.php?id=<?= $anime['mal_id'] ?>&tipo=anime" class="card-movil">
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
                        <a href="/pages/detalle.php?id=<?= $manga['mal_id'] ?>&tipo=manga">
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
        <!-- version movil top mangas - se oculta en escritorio -->
         <h2 class="titulo-movil">TOP MANGAS</h2>
        <div class="top-movil">
            <?php foreach ($top_mangas as $manga): ?>
                <a href="/pages/detalle.php?id=<?= $manga['mal_id'] ?>&tipo=manga" class="card-movil">
                    <img src="<?= $manga['images']['jpg']['large_image_url'] ?>" alt="<?= $manga['title'] ?>">
                    <p><?= $manga['title'] ?></p>
                    <p><?= $manga['score'] ?></p>
                </a>
            <?php endforeach; ?>
        </div>

    </section>
</main>

<?php
// cargamos el footer
include 'includes/footer.php';
?>