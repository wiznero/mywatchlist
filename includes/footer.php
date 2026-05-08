
<footer>
    <div class="footer-container">
        <div class="footer-logo">
            <a href="/mywatchlist/index.php"><img src="/mywatchlist/assets/img/img_site/logo-transparent.png" alt="Mywatchlist"></a>
        </div>
        <div class="footer-links">
            <a href="/mywatchlist/index.php">Inicio</a>
            <a href="/mywatchlist/pages/catalogo-animes.php">Anime</a>
            <a href="/mywatchlist/pages/catalogo-mangas.php">Manga</a>
            <?php if (!isset($_SESSION['usuario_id'])): ?>
                <a href="/mywatchlist/pages/registro.php">Crear cuenta</a>
            <?php endif; ?>
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <a href="/mywatchlist/pages/mi_lista.php">Mi lista</a>
            <?php endif; ?>

        </div>
        <p class="footer-copy">© <?= date('Y') ?> Mywatchlist · Sergio Gil · Proyecto Final DAW <br> Datos proporcionados por JIKAN API</p>
        
    </div>
</footer>





<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script src="/mywatchlist/assets/js/main.js"></script>
</body>
</html>