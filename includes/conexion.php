<?php

// creamos la conexion a la base de datos
try {
    $conn = new PDO("mysql:host=localhost;dbname=mywatchlist;charset=utf8mb4", "root", ""
);
    // ponemos el modo de error para que lance excepciones si falla
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) { 
    //si falla mostramos el mensaje y detenemos la ejecucion
    die("Error al conectar a la base de datos: " . $e->getMessage());
}






?>