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
    <section>
        <div class="container-tarjetas anime">
            <h2>Top Animes</h2>
            <?php foreach ($top_animes as $anime): ?>
            <div class="tarjeta">
                <img src="<?= $anime['images']['jpg']['large_image_url'] ?>" alt="">
                <p><?= $anime['title'] ?></p>
                <p><?= $anime['score'] ?></p>
            </div>
            <?php endforeach; ?>
        </div>
        <hr>
        <div class="container-tarjetas manga">
            <h2>Top Mangas</h2>
        </div>
    </section>
</main>

<?php
// cargamos el footer
include 'includes/footer.php';
?>