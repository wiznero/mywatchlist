#  MyWatchlist

Aplicación web para llevar el control de anime y manga favorito. Desarrollada como Trabajo de Fin de Grado del Ciclo Superior de Desarrollo de Aplicaciones Web (DAW).

##  Vista general

MyWatchlist permite a los usuarios registrarse, explorar un catálogo de anime y manga en tiempo real, y gestionar su propia lista personalizada con estados de seguimiento.

##  Funcionalidades

- **Catálogo** — exploración de anime y manga con búsqueda y filtros por género, tipo y estado
- **Detalle** — página individual de cada título con sinopsis, puntuación, episodios y más
- **Mi Lista** — añade títulos con estado personalizado (viendo, completado, pendiente, abandonado)
- **Autenticación** — registro e inicio de sesión con sesiones PHP
- **Perfil** — visualización de estadísticas y lista personal del usuario
- **Ajustes** — gestión de datos de cuenta
- **Diseño responsive** — versión escritorio con carrusel 3D CSS y versión móvil adaptada

##  Tecnologías

| Capa | Tecnología |
|------|-----------|
| Backend | PHP 8, PDO |
| Base de datos | MySQL |
| Frontend | HTML5, CSS3, JavaScript, jQuery |
| API externa | [Jikan API v4](https://jikan.moe/) (datos de MyAnimeList) |
| Servidor | Apache |
| Control de versiones | Git / GitHub |

## Estructura del proyecto

```
mywatchlist/
├── assets/          # CSS, JS e imágenes
├── includes/        # Archivos reutilizables (conexión BD, header, footer)
├── pages/           # Páginas de la aplicación
│   ├── catalogo-animes.php
│   ├── catalogo-manga.php
│   ├── detalle.php
│   ├── mi-lista.php
│   ├── perfil.php
│   ├── ajustes.php
│   ├── login.php
│   └── registro.php
└── index.php        # Página principal
```

##  Instalación local

### Requisitos previos

- PHP 8.0 o superior
- MySQL 5.7 o superior
- Apache con `mod_rewrite` habilitado (XAMPP / Laragon recomendado)

### Pasos

1. Clona el repositorio:
   ```bash
   git clone https://github.com/wiznero/mywatchlist.git
   ```

2. Copia la carpeta en el directorio raíz de tu servidor local (ej. `htdocs` en XAMPP).

3. Importa la base de datos:
   - Abre phpMyAdmin
   - Crea una base de datos llamada `mywatchlist`
   - Importa el archivo `mywatchlist.sql` (incluido en el repositorio)

4. Configura la conexión en `includes/conexion.php`:
   ```php
   $host = 'localhost';
   $bd   = 'mywatchlist';
   $user = 'root';
   $pass = '';
   ```

5. Accede desde el navegador:
   ```
   http://localhost/mywatchlist/
   ```

##  API utilizada

Este proyecto consume la [Jikan API v4](https://jikan.moe/), una API REST no oficial de MyAnimeList que no requiere autenticación. Se utiliza para obtener:

- Top animes y mangas en portada
- Catálogo completo con paginación
- Detalle individual de cada título

##  Autor

**Sergio Gil Jiménez**  
Técnico Superior en Desarrollo de Aplicaciones Web  
[GitHub](https://github.com/wiznero)
