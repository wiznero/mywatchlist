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

// consulta para obtener anime con mas puntuacion
$consulta_favanime = $conn->prepare("SELECT mal_id, tipo, calificacion FROM lista_usuarios WHERE id_usuarios = ? AND tipo = 'anime' ORDER BY calificacion DESC LIMIT 1");
$consulta_favanime->execute([$_SESSION['usuario_id']]);
$favanime = $consulta_favanime->fetch(PDO::FETCH_ASSOC);

// consulta para obtener manga con mas puntuacion
$consulta_favmanga = $conn->prepare("SELECT mal_id, tipo, calificacion FROM lista_usuarios WHERE id_usuarios = ? AND tipo = 'manga' ORDER BY calificacion DESC LIMIT 1");
$consulta_favmanga->execute([$_SESSION['usuario_id']]);
$favmanga = $consulta_favmanga->fetch(PDO::FETCH_ASSOC);

//consulta total capitulos/episodios vistos
$consulta_total_vistos = $conn->prepare("SELECT SUM(progreso) as total_progreso FROM lista_usuarios WHERE id_usuarios = ? AND estado IN ('viendo', 'completado')");
$consulta_total_vistos->execute([$_SESSION['usuario_id']]);
$total_vistos = $consulta_total_vistos->fetch(PDO::FETCH_ASSOC)['total_progreso'] ?? 0;

$stats = [];
foreach ($estadisticas_lista as $item) {
    $stats[$item['tipo']][$item['estado']] = $item['total'];
}

// consulta para obtener la actividad reciente
$consulta_actividad = $conn->prepare("SELECT * FROM lista_usuarios WHERE id_usuarios = ? ORDER BY actualizado_en DESC LIMIT 5");
$consulta_actividad->execute([$_SESSION['usuario_id']]);
$actividad = $consulta_actividad->fetchAll(PDO::FETCH_ASSOC);

// formateamos para que solo nos de la fecha, no la hora
date('d/m/Y', strtotime($perfil['fecha_registro']));


// llamamos a Jikan en un bucle para obtener los detalles de cada item en la lista del usuario
foreach ($actividad as &$item) {
    $url = "https://api.jikan.moe/v4/{$item['tipo']}/{$item['mal_id']}";
    $respuesta = file_get_contents($url);
    $datos = json_decode($respuesta, true);
    // comprobamos que jikan devuelve datos antes de asignar
    $item['datos_api'] = isset($datos['data']) ? $datos['data'] : null;
    usleep(500000);
}
 // liberamos la variable para evitar problemas de referencia
 unset($item);
 
 // llamamos a jikan para obtener los datos del anime favorito
if ($favanime) {
    $respuesta_favanime = file_get_contents("https://api.jikan.moe/v4/anime/{$favanime['mal_id']}");
    $favanime['datos_api'] = json_decode($respuesta_favanime, true)['data'];
    usleep(500000);
}

// llamamos a jikan para obtener los datos del manga favorito
if ($favmanga) {
    $respuesta_favmanga = file_get_contents("https://api.jikan.moe/v4/manga/{$favmanga['mal_id']}");
    $favmanga['datos_api'] = json_decode($respuesta_favmanga, true)['data'];
    usleep(500000);
}

// calculamos los porcentajes para mostrarlos el perfil  
$total_anime = ($stats['anime']['completado'] ?? 0) + ($stats['anime']['viendo'] ?? 0);
$total_manga = ($stats['manga']['completado'] ?? 0) + ($stats['manga']['viendo'] ?? 0);
$total = $total_anime + $total_manga;
$porcentaje_anime = $total > 0 ? round(($total_anime / $total) * 100) : 0;
$porcentaje_manga = $total > 0 ? round(($total_manga / $total) * 100) : 0;








// cargamos el header y el navbar
include __DIR__ . '/../includes/header.php';
?>

<div class="contenedor-perfil">
    <main>
        <!-- cabecera de perfil ----------------------------------------- -->
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

        <!-- estadisticas generales ----------------------------------------- -->
        <div class="estadisticas-generales">
            <div class="stat">
                <span class="stat-label">Total visto</span>
                <span class="stat-valor"><?= $total ?></span>
                <div class="stat-barras">
                    <div class="stat-barra-anime" style="width: <?= $porcentaje_anime ?>%"></div>
                    <div class="stat-barra-manga" style="width: <?= $porcentaje_manga ?>%"></div>
                </div>
                <div class="stat-porcentajes">
                    <span>Anime <?= $porcentaje_anime ?>%</span>
                    <span>Manga <?= $porcentaje_manga ?>%</span>
                </div>
            </div>
            <div class="stat">
                <span class="stat-label">Episodios y capítulos vistos</span>
                <span class="stat-valor"><?= $total_vistos ?></span>
                <div class="stat-barras">
                    <div class="stat-barra-anime" style="width: <?= $porcentaje_anime ?>%"></div>
                    <div class="stat-barra-manga" style="width: <?= $porcentaje_manga ?>%"></div>
                </div>
                <div class="stat-porcentajes">
                    <span>Anime <?= $porcentaje_anime ?>%</span>
                    <span>Manga <?= $porcentaje_manga ?>%</span>
                </div>
            </div>
        </div>

        <!-- expositores anime y manga favorito ----------------------------- -->
        <div class="favoritos">
            <!-- anime favorito -->
            <div class="fav-card">
                <?php if ($favanime && isset($favanime['datos_api'])): ?>
                    <img src="<?= $favanime['datos_api']['images']['jpg']['large_image_url'] ?>" alt="<?= $favanime['datos_api']['title'] ?>">
                    <div class="fav-info">
                        <span class="fav-tipo">Anime favorito</span>
                        <p class="fav-titulo"><?= $favanime['datos_api']['title'] ?></p>
                        <p class="fav-nota">Tu nota: <?= $favanime['calificacion'] ?>/10</p>
                    </div>
                <?php else: ?>
                    <p class="fav-vacio">Aún no tienes anime favorito</p>
                <?php endif; ?>
            </div>

            <!-- manga favorito -->
            <div class="fav-card">
                <?php if ($favmanga && isset($favmanga['datos_api'])): ?>
                    <img src="<?= $favmanga['datos_api']['images']['jpg']['large_image_url'] ?>" alt="<?= $favmanga['datos_api']['title'] ?>">
                    <div class="fav-info">
                        <span class="fav-tipo">Manga favorito</span>
                        <p class="fav-titulo"><?= $favmanga['datos_api']['title'] ?></p>
                        <p class="fav-nota">Tu nota: <?= $favmanga['calificacion'] ?>/10</p>
                    </div>
                <?php else: ?>
                    <p class="fav-vacio">Aún no tienes manga favorito</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- distribucion anime y manga ------------------------------------- -->
        <div class="estadisticas-especificas">
            <!-- estadisticas anime -->
            <div class="estadisticas-anime">
                <h3>Distribucion de Anime</h3>
                <div class="barrita">
                    <h4>Viendo</h4>
                    <span><?= $stats['anime']['viendo'] ?? 0 ?></span>
                </div>
                <div class="barrita">
                    <h4>Completado</h4>
                    <span><?= $stats['anime']['completado'] ?? 0 ?></span>
                </div>
                <div class="barrita">
                    <h4>Planeado</h4>
                    <span><?= $stats['anime']['planeado'] ?? 0 ?></span>
                </div>
                <div class="barrita">
                    <h4>Abandonado</h4>
                    <span><?= $stats['anime']['abandonado'] ?? 0 ?></span>
                </div>
            </div>

            <!-- estadisticas manga -->
            <div class="estadisticas-manga">
                <h3>Distribucion de Manga</h3>
                <div class="barrita">
                    <h4>Viendo</h4>
                    <span><?= $stats['manga']['viendo'] ?? 0 ?></span>
                </div>
                <div class="barrita">
                    <h4>Completado</h4>
                    <span><?= $stats['manga']['completado'] ?? 0 ?></span>
                </div>
                <div class="barrita">
                    <h4>Planeado</h4>
                    <span><?= $stats['manga']['planeado'] ?? 0 ?></span>
                </div>
                <div class="barrita">
                    <h4>Abandonado</h4>
                    <span><?= $stats['manga']['abandonado'] ?? 0 ?></span>
                </div>
            </div>
        </div>

        <!-- actividad reciente --------------------------------------------- -->
        <div class="actividad">
            <h3>Actividad Reciente</h3>
            <?php if (empty($actividad)): ?>
                <p>Aún no tienes actividad.</p>
            <?php else: ?>
                <?php foreach ($actividad as $item): ?>
                    <a href="/mywatchlist/pages/detalle.php?id=<?= $item['mal_id'] ?>&tipo=<?= $item['tipo'] ?>" class="item-actividad">
                        <img src="<?= $item['datos_api']['images']['jpg']['image_url'] ?? '../img/img_site/default.jpg' ?>" alt="<?= $item['datos_api']['title'] ?? 'Imagen no disponible' ?>">
                        <div>
                            <p><?= $item['datos_api']['title'] ?? 'Título no disponible' ?></p>
                            <p><?= ucfirst($item['estado']) ?> - <?= date('d/m/Y', strtotime($item['actualizado_en'])) ?></p>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>
</div>

<?php
// cargamos el footer
include __DIR__ . '/../includes/footer.php';
?>