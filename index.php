<?php
// con esto conectamos la base de datos a la pagina principal
require_once 'includes/conexion.php';
// cargamos el header y el navbar en la pagina principal
include 'includes/header.php';
?>


<main>
<?php 
if (isset($_SESSION['usuario_nombre'])) {
    echo "<h2>Bienvenido, " . htmlspecialchars($_SESSION['usuario_nombre']) . "</h2>";
} else {
    echo "Bienvenidos a Mywatchlist";
}
?>
    <p>Lleva el control de tu anime y manga favorito</p>
</main>

<?php
// cargamos el footer
include 'includes/footer.php';
?>