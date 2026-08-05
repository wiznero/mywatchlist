<?php

// Leemos las variables de entorno que Railway proporciona automáticamente
$host     = getenv('MYSQLHOST') ?: 'mysql.railway.internal';
$port     = getenv('MYSQLPORT') ?: '3306';
$dbname   = getenv('MYSQLDATABASE') ?: 'railway';
$user     = getenv('MYSQLUSER') ?: 'root';
$password = getenv('MYSQLPASSWORD') ?: 'GwBEFypIoSwTPAmVfSBMVIfzzMddHObD';

try {
    $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";
    
    $conn = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage());
}






