    <?php


    ?>


    <nav>
        <div class="nav-container">
            <div class="nav-logo">
                <a href="/index.php"><img src="/assets/img/img_site/logo-recortao.png" alt=""></a>
            </div>
            <ul class="nav-menu">
                <li><a href="/index.php">Inicio<span></span></a></li>
                <li><a href="/pages/catalogo-animes.php">Anime<span></span></a></li>
                <li><a href="/pages/catalogo-mangas.php">Manga<span></span></a></li>
                
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <li><a href="/pages/mi_lista.php">Mi lista<span></span></a></li>
                    <li class="desplegable">
                        <img src="/<?= htmlspecialchars($_SESSION['usuario_foto']) ?? 'assets/img/img_usuario/default.jpg' ?>" alt="Foto de perfil" class="foto-perfil">
                        <div class="desplegable-menu">
                            <a href="/pages/perfil.php">Perfil</a>
                            <a href="/pages/ajustes.php">Ajustes</a>
                            <a href="/pages/logout.php">Cerrar sesión</a>
                        </div>
                    </li>
                <?php else: ?>
                    <li><a href="/pages/registro.php">Login<span></span></a></li>
                <?php endif; ?>
            </ul>
            <button class="hamburguesa" id="hamburguesa">
                <ion-icon name="menu-outline"></ion-icon>
            </button>
        </div>
    </nav>
