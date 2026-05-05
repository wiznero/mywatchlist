<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/conexion.php';
require_once __DIR__ . '/../includes/proteger.php';

// consulta para obtener los datos actuales del usuario
$consulta_usuarios = $conn ->prepare("SELECT * FROM usuarios WHERE id = ?");
$consulta_usuarios ->execute([$_SESSION['usuario_id']]);
$perfil = $consulta_usuarios-> fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nueva_bio = $_POST['bio'] ?? '';
    $nuevo_email = $_POST['email'] ?? '';
    $nueva_contrasena = $_POST['contrasena'] ?? '';
    $confirmar_contrasena = $_POST['contrasena_confirm'] ?? '';
    $error = null;

    // foto
    if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === 0) {
        $archivo = $_FILES['foto_perfil'];
        $tipos_permitidos = ['image/jpeg', 'image/png', 'image/webp'];
        if (!in_array($archivo['type'], $tipos_permitidos)) {
            $error = 2;
        } elseif ($archivo['size'] > 2 * 1024 * 1024) {
            $error = 3;
        } else {
            $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
            $nuevo_nombre = 'perfil_' . $_SESSION['usuario_id'] . '.' . $extension;
            $destino = __DIR__ . '/../assets/img/img_usuario/' . $nuevo_nombre;
            if (move_uploaded_file($archivo['tmp_name'], $destino)) {
                $ruta_bd = 'assets/img/img_usuario/' . $nuevo_nombre;
                $stmt = $conn->prepare("UPDATE usuarios SET foto = ? WHERE id = ?");
                $stmt->execute([$ruta_bd, $_SESSION['usuario_id']]);
                $_SESSION['usuario_foto'] = $ruta_bd; // actualiza la sesión
            }
            
        }
    }

    // bio y email
    $stmt = $conn->prepare("UPDATE usuarios SET bio = ?, email = ? WHERE id = ?");
    $stmt->execute([$nueva_bio, $nuevo_email, $_SESSION['usuario_id']]);

    // contraseña
    if ($nueva_contrasena !== '') {
        if ($nueva_contrasena === $confirmar_contrasena) {
            $hash = password_hash($nueva_contrasena, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE usuarios SET contraseña = ? WHERE id = ?");
            $stmt->execute([$hash, $_SESSION['usuario_id']]);
        } else {
            $error = 1;
        }
    }

    if ($error) {
        header("Location: ajustes.php?error={$error}");
    } else {
        header("Location: ajustes.php?success=1");
    }
    exit;
}

include __DIR__ . '/../includes/header.php';
?>

<main>
    <div class="contenedor-ajustes">
        
        <div class="cabecera-ajustes">
            <h1>Configuración de la cuenta</h1>
        </div>

        <form action="ajustes.php" method="POST" enctype="multipart/form-data">
            <?php if (isset($_GET['success'])): ?>
                <p class="mensaje-exito">Cambios guardados correctamente.</p>
            <?php endif; ?>
            <?php if (isset($_GET['error'])): ?>
                <p class="mensaje-error">Las contraseñas no coinciden.</p>
            <?php endif; ?>
            
            <!-- Seccion foto de perfil -->
            <div class="seccion-ajuste">
                <h3>Foto de perfil</h3>
                <div class="foto-actual">
                    <img src="/mywatchlist/assets/img/img_usuario/<?= basename($perfil['foto']) ?>" alt="Foto de perfil actual" class="foto-perfil-ajuste">
                </div>
                <input type="file" name="foto_perfil" accept="image/*" class="input-file">
            </div>

            <!-- Seccion bio -->
            <div class="seccion-ajuste">
                <h3>Biografía</h3>
                <textarea name="bio" class="input-oscuro" placeholder="Escribe algo interesante sobre ti..."><?= htmlspecialchars($perfil['bio'] ?? '') ?></textarea>
            </div>

            <!-- Seccion email -->
            <div class="seccion-ajuste">
                <h3>Email</h3>
                <input type="email" name="email" class="input-oscuro" value="<?= htmlspecialchars($perfil['email'] ?? '') ?>">
            </div>

            <!-- Seccion contraseña -->
            <div class="seccion-ajuste">
                <h3>Contraseña</h3>
                <input type="password" name="contrasena" class="input-oscuro" placeholder="Nueva contraseña">
                <input type="password" name="contrasena_confirm" class="input-oscuro" placeholder="Confirmar nueva contraseña">
            </div>

            <button type="submit" class="boton-guardar-ajustes">Guardar cambios</button>
        </form>

    </div>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>