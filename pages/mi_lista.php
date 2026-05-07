<?php
// incluimos los archivos necesarios
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/conexion.php';
require_once __DIR__ . '/../includes/proteger.php';

// obtenemos la lista del usuario
$consulta = $conn->prepare("SELECT * FROM lista_usuarios WHERE id_usuarios = ?");
$consulta->execute([$_SESSION['usuario_id']]);
$lista_usuario = $consulta->fetchAll(PDO::FETCH_ASSOC);

// llamamos a Jikan en un bucle para obtener los detalles de cada item en la lista del usuario
 foreach ($lista_usuario as &$item) {
    $url = "https://api.jikan.moe/v4/{$item['tipo']}/{$item['mal_id']}";
    $respuesta = file_get_contents($url);
    $datos  = json_decode($respuesta,true);
    $item['datos_api'] = $datos['data'];
    usleep(500000); // para no saturar la api de jikan

 }
 // liberamos la variable para evitar problemas de referencia
 unset($item); 


















// cargamos el header y el navbar en la pagina principal
include __DIR__ . '/../includes/header.php';
?>

<main>
    <h1>Mi lista</h1>

    <div class="filtros">
        <button type="button" class="filtro-btn" data-filtro="todos">Todos</button>
        <button type="button" class="filtro-btn" data-filtro="anime">Anime</button>
        <button type="button" class="filtro-btn" data-filtro="manga">Manga</button>
        <button type="button" class="filtro-btn" data-filtro="viendo">Viendo</button>
        <button type="button" class="filtro-btn" data-filtro="completado">Completado</button>
        <button type="button" class="filtro-btn" data-filtro="planeado">Planeado</button>
        <button type="button" class="filtro-btn" data-filtro="abandonado">Abandonado</button>
    </div>
    
    <div class="grid-lista">
        <?php foreach ($lista_usuario as $item): ?>
            <div class="card-lista" data-tipo="<?= $item['tipo'] ?>" data-estado="<?= $item['estado'] ?>">
                <a href="/mywatchlist/pages/detalle.php?id=<?= $item['mal_id'] ?>&tipo=<?= $item['tipo'] ?>">
                    <img src="<?= $item['datos_api']['images']['jpg']['large_image_url'] ?>" alt="">
                </a>
                <h3><?= htmlspecialchars($item['datos_api']['title']) ?></h3>
                <p>Estado: <?= htmlspecialchars($item['estado']) ?></p>
                <p>Progreso: <?= htmlspecialchars($item['progreso']) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</main>



<script src="/mywatchlist/assets/js/mi_lista.js"></script>
<?php
// cargamos el footer
include __DIR__ . '/../includes/footer.php';
?>