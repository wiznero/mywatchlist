<?php
// Evitamos iniciar sesión si ya hay una activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
>?