<?php
// incluimos las conexiones a la base de datos y a la sesion y la proteccion de la pagina para usuarios no logueados
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/conexion.php';
require_once __DIR__ . '/../includes/proteger.php';

//consulta para obtener los datos del usuario
$consulta_usuarios = $conn ->prepare("SELECT * FROM usuarios WHERE id = ?");
$consulta_usuarios ->execute([$_SESSION['usuario_id']]);
$perfil = $consulta_usuarios-> fetch(PDO::FETCH_ASSOC);

//consulta para obtener el numero de items de la lista del usuario
$consulta_lista = $conn->prepare("SELECT tipo,estado, COUNT(*) as total FROM lista_usuarios WHERE id_usuarios = ? GROUP BY tipo,estado");
$consulta_lista->execute([$_SESSION['usuario_id']]);
$estadisticas_lista = $consulta_lista-> fetchALL(PDO::FETCH_ASSOC);

$stats = [];
foreach ($estadisticas_lista as $item) {
    $stats[$item['tipo']][$item['estado']] = $item['total'];
}

// formateamos para que solo nos de la fecha, no la hora
date('d/m/Y', strtotime($perfil['fecha_registro']));












// cargamos el header y el navbar
include __DIR__ . '/../includes/header.php';
?>

<div class="contenedor-perfil">
    <main>
        <div class="cabecera-perfil">
            <img src="/mywatchlist/assets/img/img_usuario/<?= basename($perfil['foto']) ?>" alt="Foto de perfil" class="foto-perfil">
            <div class="info-perfil">
                <div class="nombre-fecha">
                    <h1><?= $_SESSION['usuario_nombre'] ?></h1>
                    <span>otaku desde <?= date('Y', strtotime($perfil['fecha_registro'])) ?></span>
                </div>
                <p class="bio"><?= $perfil['bio'] ?></p>
            </div>
        </div>

        <div class="estadisticas-generales">
            <div class="stat">
                <span>total anime</span>
                <span><?= array_sum($stats['anime'] ?? []) ?></span>
            </div>
            <div class="stat">
                <span>Total Manga</span>
                <span><?= array_sum($stats['manga'] ?? []) ?></span>
            </div>
            <div class="stat">
                <span>En progreso</span>
                <span><?= ($stats['anime']['viendo'] ?? 0) + ($stats['manga']['viendo'] ?? 0) ?></span>
            </div>
            <div class="stat">
                <span>Abandonados</span>
                <span><?= ($stats['anime']['abandonado'] ?? 0) + ($stats['manga']['abandonado'] ?? 0) ?></span>
            </div>
        </div>
        <div class="estadisticas-especificas">
            <!-- // estadisticas anime ---------------------------------------------- -->
            <div class="estadisticas-anime">
                <h3>Distribucion de Anime</h3>
                <div class="barrita">
                    <h4>Viendo</h4>
                    <span><?= $stats['anime']['viendo'] ?? 0 ?></span>
                    
                </div>
                <div class="barrita">
                    <h4>completado</h4>
                    <span><?= $stats['anime']['completado'] ?? 0 ?></span>
                </div>
                <div class= "barrita">
                    <h4>Planeado</h4>
                    <span><?= $stats['anime']['planeado'] ?? 0 ?></span>
                </div>
                <div class= "barrita">
                    <h4>Abandonado</h4>
                    <span><?= $stats['anime']['abandonado'] ?? 0 ?></span>
                </div>
                

            </div>


            <!-- // estadisticas manga ---------------------------------------------- -->
            <div class="estadisticas-manga">
                <h3>Distribucion de Manga</h3>
                <div class="barrita">
                    <h4>Viendo</h4>
                    <span><?= $stats['manga']['viendo'] ?? 0 ?></span>                
                </div>
                <div class="barrita">
                    <h4>completado</h4>
                    <span><?= $stats['manga']['completado'] ?? 0 ?></span>

                </div>
                <div class= "barrita">
                    <h4>Planeado</h4>
                    <span><?= $stats['manga']['planeado'] ?? 0 ?></span>

                </div>
                <div class= "barrita">
                    <h4>Abandonado</h4>
                    <span><?= $stats['manga']['abandonado'] ?? 0 ?></span>

                </div>
                

            </div>



        </div>
        <div Class="actividad">
            <h2>Actividad Reciente</h2>


        </div>
    </main>
</div>

<?php
// cargamos el footer
include __DIR__ . '/../includes/footer.php';
?>