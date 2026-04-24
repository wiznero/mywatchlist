<?php
require_once __DIR__ . '/../includes/conexion.php';
include __DIR__ . '/../includes/header.php';

if (isset($_GET['id']) && isset($_GET['tipo'])) {
    $id = $_GET['id'];
    $tipo = $_GET['tipo'];
}

// llamamos a Jikan 
$respuesta = file_get_contents("https://api.jikan.moe/v4/{$tipo}/{$id}");
$datos = json_decode($respuesta, true);
$item = $datos['data'];
?>

<div class="contenedor-detalle">

    <div class="cabecera-detalle">
        <div class="portada">
            <!-- Imagen de portada: $item['images']['webp']['large_image_url'] -->
        </div>

        <div class="info-cabecera">
            <div class="etiquetas">
                <span class="etiqueta etiqueta-tipo">Anime/Manga</span>
                <span class="etiqueta etiqueta-estado">Estado</span>
            </div>

            <h1 class="titulo">Título del anime</h1>
            <h2 class="subtitulo-estudio">Nombre del estudio</h2>

            <div class="metricas">
                <div class="metrica">
                    <span class="metrica-label">Puntuación</span>
                    <span class="metrica-valor">0.0</span>
                </div>
                <div class="metrica">
                    <span class="metrica-label">Episodios</span>
                    <span class="metrica-valor">00</span>
                </div>
                <div class="metrica">
                    <span class="metrica-label">Popularidad</span>
                    <span class="metrica-valor">#0k</span>
                </div>
            </div>
        </div>
    </div>

    <div class="contenido-grid">
        
        <div class="columna-izquierda">
            
            <section class="seccion-generos">
                <h3>Géneros</h3>
                <div class="chips">
                    <span class="chip">Género 1</span>
                    <span class="chip">Género 2</span>
                    <span class="chip">Género 3</span>
                </div>
            </section>

            <section class="seccion-estudio">
                <h3>Estudio</h3>
                <p class="nombre-estudio">Nombre del estudio</p>
            </section>

            <section class="seccion-sinopsis">
                <h3>Sinopsis</h3>
                <p class="sinopsis">Texto de la sinopsis...</p>
            </section>
        </div>

        <div class="columna-derecha">
            
            <section class="bloque-lista-usuario">
                <h3>Tu lista</h3>
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
                        <input type="range" id="calificacion" min="0" max="10" value="0" class="slider-neon" oninput="document.getElementById('calificacion-valor').innerText = this.value">
                    </div>

                    <div class="grupo-form">
                        <label for="progreso">Progreso: <span id="progreso-valor">0</span>/00 ep</label>
                        <input type="range" id="progreso" min="0" max="100" value="0" class="slider-neon" oninput="document.getElementById('progreso-valor').innerText = this.value">
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