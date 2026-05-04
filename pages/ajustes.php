<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/conexion.php';
require_once __DIR__ . '/../includes/proteger.php';

// consulta para obtener los datos actuales del usuario
$consulta_usuarios = $conn ->prepare("SELECT * FROM usuarios WHERE id = ?");
$consulta_usuarios ->execute([$_SESSION['usuario_id']]);
$perfil = $consulta_usuarios-> fetch(PDO::FETCH_ASSOC);

// procesar el formulario cuando se envie
if ($_SERVER['REQUEST_METHOD'] === '...') {
    // recoger los datos del formulario
    $nueva_bio = $_POST['...'] ?? '';
    $nuevo_email = $_POST['...'] ?? '';
    
    // actualizar en la base de datos
    $actualizar = $conn->prepare("UPDATE usuarios SET ... WHERE ...");
    $actualizar->execute([...]);
    
    // redirigir con mensaje de exito
    header("Location: ...");
    exit;
}

include __DIR__ . '/../includes/header.php';
?>

<main>
    <div class="contenedor-ajustes">
        
        <div class="cabecera-ajustes">
            <h1>...</h1>
        </div>

        <form action="..." method="...">
            
            <!-- Seccion foto de perfil -->
            <div class="seccion-ajuste">
                <h3>...</h3>
                <div class="foto-actual">
                    <img src="..." alt="...">
                </div>
                <input type="file" name="..." accept="...">
            </div>

            <!-- Seccion bio -->
            <div class="seccion-ajuste">
                <h3>...</h3>
                <textarea name="..." placeholder="...">...</textarea>
            </div>

            <!-- Seccion email -->
            <div class="seccion-ajuste">
                <h3>...</h3>
                <input type="email" name="..." value="...">
            </div>

            <!-- Seccion contraseña -->
            <div class="seccion-ajuste">
                <h3>...</h3>
                <input type="password" name="..." placeholder="...">
                <input type="password" name="..." placeholder="...">
            </div>

            <button type="submit">...</button>
        </form>

    </div>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>