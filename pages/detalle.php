<?php
if (isset($_GET['id']) && isset($_GET['tipo'])) {
    $id = $_GET['id'];
    $tipo = $_GET['tipo'];
}

if (!$id) {
    header('Location: index.php');
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
    $total_entregas = $item['chapters'] ?? '00';
    $etiqueta = 'Capitulos';
    $estudio = $item['authors'][0]['name'] ?? 'Autor desconocido';
    $unidad_medida = 'ch'; //para el formulario de progreso
};

//inclimos los demas archivos
require_once __DIR__ . '/../includes/conexion.php';
include __DIR__ . '/../includes/header.php';
?>

<div class="contenedor-detalle">

    <div class="cabecera-detalle">
        <div class="portada">
           <img src="<?= $item['images']['jpg']['large_image_url'] ?? 'MYWATCHLIST//assets/img/img_site/astronauta.png' ?>" alt="Portada de <?= $item['title'] ?? 'Anime'?>">
        </div>

        <div class="info-cabecera">
            <div class="etiquetas">
                <span class="etiqueta etiqueta-tipo"><?= ucfirst($tipo)  ?></span>
                <span class="etiqueta etiqueta-estado"><?=  $item['status'] ?></span>
            </div>

            <h1 class="titulo"><?= $item['title'] ?></h1>
            <h1 class="subtitulo-estudio"><?= $estudio ?></h1>



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
                    <span class="metrica-valor"><?= $item['popularity'] ?? '#0k' ?></span>
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
            
            <section class="bloque-lista-usuario">
                <h3>Tu lista</h3>
                 <!-- Formulario de progreso -->
                <form action="#">
                    <div class="grupo-form">
                        <label for="estado">Estado</label>
                        <select id="estado" class="input-oscuro">
                            <option value="viendo">Viendo</option>
                            <option value="completado">Completado</option>
                            <option value="planeado">Planeado</option>
                            <option value="abandonado">Abandonado</option>
                        </select>
                    </div>

                    <div class="grupo-form">
                        <label for="calificacion">Calificación: <span id="calificacion-valor">0</span>/10</label>
                        <input type="range" id="calificacion" min="0" max="10" value="0" class="slider-neon">
                    </div>

                    <div class="grupo-form">
                        <label for="progreso">Progreso: <span id="progreso-valor">0</span>/<?= $total_entregas ?> <?= $unidad_medida ?></label>
                        <input type="range" id="progreso" min="0" max="<?= is_numeric($total_entregas) ? $total_entregas : 100 ?>" value="0" class="slider-neon">
                    </div>

                    <div class="grupo-form">
                        <label for="notas">Notas</label>
                        <textarea id="notas" class="input-oscuro" placeholder="Escribe tus notas aquí..."></textarea>
                    </div>

                    <div class="acciones">
                        <button type="button" class="boton boton-guardar">Guardar</button>
                        <button type="button" class="boton boton-cancelar">Cancelar</button>
                    </div>
                </form>
            </section>
        </div>

    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>