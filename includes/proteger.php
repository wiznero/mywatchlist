<?php
if (!isset($_SESSION['usuario_id'])) {
    header('Location: /mywatchlist/pages/registro.php');
    exit();
}
?>