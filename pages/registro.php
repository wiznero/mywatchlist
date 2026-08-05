
<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if ($_POST['accion'] == 'registro') {
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $pass = $_POST['password'];
        
        //validamos que los campos no esten vacios
        if (empty($nombre) || empty($email) || empty($pass)) {
            $error = "Todos los campos son obligatorios";
        }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "El email no tiene un formato válido";
        }elseif (strlen($pass) < 10) {
            $error = "La contraseña tiene que tener al menos 10 caracteres";
        }else {
            $consulta = $conn->prepare("SELECT id FROM usuarios WHERE email = ? OR user = ?");
            $consulta->execute([$email, $nombre]);
            $usuario_existe = $consulta->fetch();
            if ($usuario_existe) {
                $error = "El email o el nombre de usuario ya están en uso";
            }else {
                $pass = password_hash($pass, PASSWORD_DEFAULT);
                $conn_Insert = $conn->prepare("INSERT INTO usuarios (user, contraseña, email) VALUES (?,?,?)");
                $conn_Insert->execute([$nombre,$pass,$email]);
                header('Location: /mywatchlist/pages/registro.php?registro=exitoso');
                exit();
            }
        }

        

        
        
    } elseif ($_POST['accion'] == 'login') {
        $email = $_POST['email'];
        $pass = $_POST['password'];

        $consulta_log = $conn->prepare("SELECT id, user, contraseña, foto FROM usuarios WHERE email = ?");
        $consulta_log->execute([$email]);
        $usuario_existe = $consulta_log->fetch();
            if (!$usuario_existe || !password_verify($pass, $usuario_existe['contraseña'])) {
                $error = "El email no existe o la contraseña es incorrecta";
            } else {
                $_SESSION['usuario_id'] = $usuario_existe['id'];     // guardas datos
                $_SESSION['usuario_nombre'] = $usuario_existe['user']; // guardas más datos
                $_SESSION['usuario_foto'] = $usuario_existe['foto']; // guardas las foto de perfil

                //volvemos a la pagina principal
                header('Location: /mywatchlist/index.php');
                exit();
            }
    }
}
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/estilos-login.css">
    <title>Login/registro</title>
</head>
<body>

    <div class="container" id="container">
        <div class="form-container registro">
            <form action="" method="POST">
                <h1>Crear cuenta</h1>
                <!-- <div class="iconos">
                    <a href="#" class="icono"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icono"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icono"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#" class="icono"><i class="fa-brands fa-instagram"></i></a>
                </div> -->
                <!-- <span>o registrate con tu correo</span> -->
                <input type="text" name="nombre" placeholder="Nombre">
                <input type="email" name="email" placeholder="Email">
                <div class="input-password">
                    <input type="password" id="password-registro" name="password" placeholder="Contraseña">
                    <ion-icon name="eye-outline" id="toggle-password-registro"></ion-icon>
                </div>
                <input type="hidden" name="accion" value="registro">
                <?php if (isset($error)): ?>
                <p class="error"><?= $error ?></p>
                <?php endif; ?>

                <?php if (isset($_GET['registro']) && $_GET['registro'] == 'exitoso'): ?>
                <p class="exito">¡Cuenta creada correctamente!</p>
                <?php endif; ?>
                <button>Crear cuenta</button>
                <a href="/index.php" class="btn-secondary">← Volver al inicio</a>
            </form>
        </div>
        <div class="form-container sign-in">
            <form action="" method="POST">
                <h1>Iniciar sesión</h1>
                <!-- <div class="iconos">
                    <a href="#" class="icono"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icono"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icono"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#" class="icono"><i class="fa-brands fa-instagram"></i></a>
                </div> -->
                <!-- <span>o inicia sesion con tu correo</span> -->
                <input type="email" name="email" placeholder="Email">
                <div class="input-password">
                    <input type="password" id="password" name="password" placeholder="Contraseña">
                    <ion-icon name="eye-outline" id="toggle-password"></ion-icon>
                </div>
                <a href="#">¿has olvidado tu contraseña?</a>
                <input type="hidden" name="accion" value="login">
                <?php if (isset($error) && isset($_POST['accion']) && $_POST['accion'] == 'login'): ?>
                    <p class="error"><?= $error ?></p>
                <?php endif; ?>
                <button>Iniciar sesión</button>
                <a href="/index.php" class="btn-secondary">← Volver al inicio</a>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>¡Bienvenido!</h1>
                    <p>Inicia sesion con tus datos</p>
                    <button class="hidden" id="login">Entrar</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>¡Bienvenido De Nuevo!</h1>
                    <p>Regístrate para comenzar</p>
                    <button class="hidden" id="register">Crear cuenta</button>
                </div>
            </div>
        </div>
    </div>

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script src="../assets/js/login.js"></script>
</body>
</html>