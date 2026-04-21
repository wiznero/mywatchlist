<?php
// con esto conectamos la base de datos a la pagina principal
require_once 'includes/conexion.php';
// cargamos el header y el navbar en la pagina principal
include 'includes/header.php';
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
    <section>
        <div class="container-tarjetas">
            <p>AQUI VAN LOS ANIMES</p>
        </div>
    </section>
</main>

<?php
// cargamos el footer
include 'includes/footer.php';
?>