<?php
// incluimos los archivos necesarios
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/conexion.php';
require_once __DIR__ . '/../includes/proteger.php';

// obtenemos la lista del usuario
$consulta = $conn->prepare("SELECT * FROM lista_usuarios WHERE id_usuarios = ?");
$consulta->execute([$_SESSION['usuario_id']]);
$lista_usuario = $consulta->fetchAll(PDO::FETCH_ASSOC);

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
                    <img src="<?= $item['imagen'] ?>" alt="<?= htmlspecialchars($item['titulo']) ?>">
                </a>
                <h3><?= htmlspecialchars($item['titulo']) ?></h3>
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