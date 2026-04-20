<?php
// con esto conectamos la base de datos a la pagina principal
require_once __DIR__ . '/../includes/conexion.php';
// cargamos el header y el navbar en la pagina principal
include __DIR__ . '/../includes/header.php';
// protegemos las paginas a las que solo se accede con cuenta
require_once __DIR__ . '/../includes/proteger.php';

?>


<?php if (isset($_SESSION['usuario_nombre'])): ?>
    <h2>Bienvenido, <?= htmlspecialchars($_SESSION['usuario_nombre']) ?></h2>
<?php endif; ?>

<main>
    <p>Bienvenido a tu Perfil</p>
</main>

<?php
// cargamos el footer
include __DIR__ . '/../includes/footer.php';
?>