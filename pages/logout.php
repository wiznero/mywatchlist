<?php
require_once __DIR__ . '/../includes/session.php';

// destruimos todos los datos de la sesión
session_destroy();

// redirigimos al index
header('Location: /mywatchlist/index.php');
exit();
?>