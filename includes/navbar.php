    <?php


    ?>


    <nav>
        <div class="nav-container">
            <div class="nav-logo">
                <a href="/mywatchlist/index.php"><img src="/mywatchlist/assets/img/img_site/logo-recortao.png" alt=""></a>
            </div>
            <!-- <div class="searchBox">
                <div class="search">
                    <ion-icon name="search-outline"></ion-icon>
                </div>
                <div class="searchInput">
                    <input type="text" placeholder="buscar... ">
                </div>
                <div class="close">
                    <ion-icon name="close-outline"></ion-icon>
                </div>
            </div> -->
            <ul class="nav-menu">
                <li><a href="/mywatchlist/index.php">Inicio<span></span></a></li>
                <li><a href="/mywatchlist/pages/catalogo-animes.php">Anime<span></span></a></li>
                <li><a href="/mywatchlist/pages/catalogo-mangas.php">Manga<span></span></a></li>
                
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <li><a href="/mywatchlist/pages/mi_lista.php">Mi lista<span></span></a></li>
                    <li class="desplegable">
                        <img src="/mywatchlist/assets/img/img_usuario/default.jpg" class="foto-perfil">
                        <div class="desplegable-menu">
                            <a href="/mywatchlist/pages/perfil.php">Perfil</a>
                            <a href="/mywatchlist/pages/ajustes.php">Ajustes</a>
                            <a href="/mywatchlist/pages/logout.php">Cerrar sesión</a>
                        </div>
                    </li>
                <?php else: ?>
                    <li><a href="/mywatchlist/pages/registro.php">Login<span></span></a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
