<?php
//inclimos la conexion a la bbdd y la sesion para el progreso de usuario
require_once __DIR__ . '/../includes/conexion.php';
require_once __DIR__ . '/../includes/session.php';


if (isset($_GET['id']) && isset($_GET['tipo'])) {
    $id = $_GET['id'];
    $tipo = $_GET['tipo'];
}

if (!isset($_GET['id']) || !isset($_GET['tipo'])) {
    header('Location: /mywatchlist/index.php');
    exit;
}

// si el formulario se ha enviado, guardamos el progreso en la bbdd
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = $_SESSION['usuario_id'] ?? null;
    $item_id = $_POST['item_id'] ?? null;
    $item_tipo = $_POST['item_tipo'] ?? null;
    $estado = $_POST['estado'] ?? '';
    $calificacion = $_POST['calificacion'] ?? 0;
    $progreso = $_POST['progreso'] ?? 0;
    $notas = $_POST['notas'] ?? '';

    // usamos la consulta on DUPLICATE KEY UPDATE para insertar o actualizar el progreso del usuario
    $añadir_lista = $conn->prepare("INSERT INTO lista_usuarios (id_usuarios, mal_id, tipo, estado, calificacion, progreso, notas)
    VALUES (?, ?, ?, ?, ?, ?, ?)
    ON DUPLICATE KEY UPDATE 
        estado = VALUES(estado),
        calificacion = VALUES(calificacion),
        progreso = VALUES(progreso),
        notas = VALUES(notas)");
    $añadir_lista->execute([$id_usuario, $item_id, $item_tipo, $estado, $calificacion, $progreso, $notas]);
    header("Location: detalle.php?id={$item_id}&tipo={$item_tipo}&guardado=1");
    exit;


}

// llamamos a Jikan 
$respuesta = file_get_contents("https://api.jikan.moe/v4/{$tipo}/{$id}");
$datos = json_decode($respuesta, true);
$item = $datos['data'];


if (strtolower($tipo) == 'anime') {
    $total_entregas = $item['episodes'] ?? '00';
    $etiqueta = 'Episodios';
    //accedemos al primer estudio
    $estudio = $item['studios'][0]['name'] ?? 'Estudio desconocido';
    $unidad_medida = 'ep'; //para el formulario de progreso
}else {
    $total_entregas = $item['chapters'] ?? '?';
    $etiqueta = 'Capitulos';
    $estudio = $item['authors'][0]['name'] ?? 'Autor desconocido';
    $unidad_medida = 'ch'; //para el formulario de progreso
};

// si el usuario esta logueado, traemos su progreso
if (isset($_SESSION['usuario_id'])) {
$consulta = $conn->prepare("SELECT estado, calificacion, progreso, notas FROM lista_usuarios WHERE id_usuarios = ? AND mal_id = ? AND tipo = ?");
$consulta->execute([$_SESSION['usuario_id'] ?? 0, $id, $tipo]);
$progreso_usuario = $consulta->fetch();
}

//inclimos el header
include __DIR__ . '/../includes/header.php';
?>



<div class="contenedor-detalle">

    <div class="cabecera-detalle">
        <div class="portada">
           <img src="<?= $item['images']['jpg']['large_image_url'] ?? '/mywatchlist/assets/img/img_site/astronauta.png' ?>" alt="Portada de <?= $item['title'] ?? 'Anime'?>">
        </div>

        <div class="info-cabecera">
            <div class="etiquetas">
                <span class="etiqueta etiqueta-tipo"><?= ucfirst($tipo)  ?></span>
                <span class="etiqueta etiqueta-estado"><?=  $item['status'] ?></span>
            </div>

            <h1 class="titulo"><?= $item['title'] ?></h1>
            <h2 class="subtitulo-estudio"><?= $estudio ?></h2>



            <div class="metricas">
                <div class="metrica">
                    <span class="metrica-label">Puntuación</span>
                    <span class="metrica-valor"><?= $item['score'] ?? '0.0' ?></span>
                </div>
                <div class="metrica">
                    <span class="metrica-label"><?= $etiqueta ?></span>
                    <span class="metrica-valor"><?= $total_entregas ?></span>
                </div>
                <div class="metrica">
                    <span class="metrica-label">Popularidad</span>
                    <span class="metrica-valor">#<?= $item['popularity'] ?? '0' ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="contenido-grid">
        
        <div class="columna-izquierda">
            
            <section class="seccion-generos">
                <h3>Géneros</h3>
                <div class="chips">
                    <?php if (!empty($item['genres'])): ?>
                        <?php foreach ($item['genres'] as $genero): ?>
                            <span class="chip"><?= $genero['name'] ?></span>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <span class="chip">Sin géneros</span>
                    <?php endif; ?>
                </div>
            </section>

            <section class="seccion-estudio">
                <h3>Estudio</h3>
                <p class="nombre-estudio"><?= $estudio ?></p>
            </section>

            <section class="seccion-sinopsis">
                <h3>Sinopsis</h3>
                <p class="sinopsis"><?= $item['synopsis'] ?? 'No hay una sinopsis disponible.'?></p>
            </section>
        </div>

        <div class="columna-derecha">
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <section class="bloque-lista-usuario">
                    <h3>Tu lista</h3>
                    <!-- Formulario de progreso -->
                    <form action="" method="POST">
                        <input type="hidden" name="item_id" value="<?= $id ?>">
                        <input type="hidden" name="item_tipo" value="<?= $tipo ?>">
                        
                        <div class="grupo-form">
                            <label for="estado">Estado</label>
                            <select id="estado" name="estado" class="input-oscuro">
                                <option value="viendo" <?= ($progreso_usuario['estado'] ?? '') == 'viendo' ? 'selected' : '' ?>>Viendo</option>
                                <option value="completado" <?= ($progreso_usuario['estado'] ?? '') == 'completado' ? 'selected' : ''?>>Completado</option>
                                <option value="planeado" <?= ($progreso_usuario['estado'] ?? '') == 'planeado' ? 'selected' : ''?>>Planeado</option>
                                <option value="abandonado" <?= ($progreso_usuario['estado'] ?? '') == 'abandonado' ? 'selected' : ''?>>Abandonado</option>
                            </select>
                        </div>

                        <div class="grupo-form">
                            <label for="calificacion">Calificación: <span id="calificacion-valor"><?= $progreso_usuario['calificacion'] ?? 0 ?></span>/10</label>
                            <input type="range" id="calificacion" name="calificacion" min="0" max="10" value="<?= $progreso_usuario['calificacion'] ?? 0 ?>" class="slider-neon">
                        </div>

                        <div class="grupo-form">
                            <label for="progreso">Progreso: <span id="progreso-valor"><?= $progreso_usuario['progreso'] ?? 0 ?></span>/<?= $total_entregas ?> <?= $unidad_medida ?></label>
                            <input type="range" id="progreso" name="progreso" min="0" max="<?= is_numeric($total_entregas) ? $total_entregas : 9999 ?>" value="<?= $progreso_usuario['progreso'] ?? 0 ?>" class="slider-neon">
                        </div>

                        <div class="grupo-form">
                            <label for="notas">Notas</label>
                            <textarea id="notas" name="notas" class="input-oscuro" placeholder="Escribe tus notas aquí..."><?= $progreso_usuario['notas'] ?? '' ?></textarea>
                        </div>

                        <div class="acciones">
                            <button type="submit" class="boton boton-guardar">Guardar</button>
                            <button type="button" class="boton boton-cancelar">Cancelar</button>
                        </div>
                    </form>
                </section>
                <?php else: ?>
                    <p>Inicia sesión para añadir a tu lista</p>
                <?php endif; ?>
        </div>

    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>