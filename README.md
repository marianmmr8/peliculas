# Películas

Aplicación PHP para administrar películas y directores. Usa MySQL/MariaDB mediante PDO y está pensada para ejecutarse localmente con XAMPP.

## Carpetas

- `clases/`: modelos (`peliculas.php`, `director.php`) y acceso a la base de datos (`peliculasDAO.php`, `directorDao.php`).
- `datos/`: conexión (`config.php`), SQL de la base (`peliculas_bd.sql`) y datos de ejemplo de directores (`directores.sql`). `config.php` es local y no se debe publicar.
- `panel/`: página principal del panel y formularios/acciones para películas (`pelicula/`) y directores (`director/`).
- `css/`: estilos compartidos del panel y formularios (`panel.css`).
- `images/`: carátulas subidas y otras imágenes utilizadas por la aplicación.

## Puesta en marcha

1. Coloca el proyecto dentro de `C:\xampp\htdocs\peliculas`.
2. Inicia Apache y MySQL en XAMPP y crea una base de datos llamada `peliculas_bd`.
3. Importa `datos/peliculas_bd.sql` desde phpMyAdmin. Hazlo una sola vez en una base nueva; crea las tablas `director` y `peliculas`.
4. Comprueba que `datos/config.php` tenga las variables `$servidor`, `$nombreBase`, `$usuario` y `$password` correctas para tu instalación.
5. Abre `http://localhost/peliculas/panel/`.

El usuario y contraseña de MySQL dependen de la instalación local. No compartas ni subas `datos/config.php` con credenciales reales.

## Cómo está organizado el código

### Modelos en `clases/`

- `Director`: guarda `id`, `nombre`, `anioNacimiento` y `biografia`. Su constructor recibe nombre, nacimiento, biografía e ID opcional. Los getters (`getNombre()`, `getAnioNacimiento()`, etc.) leen sus datos y los setters los modifican.
- `peliculas`: guarda `id`, `titulo`, `director`, `anio`, `genero`, `imagen` y `visto`. Su constructor recibe esos datos; los getters y setters permiten consultarlos y actualizarlos.

### Acceso a datos

`directorDao` y `peliculasDAO` abren una conexión PDO usando las variables de `datos/config.php`.

Ambos DAO ofrecen:

- `getAll()`: devuelve todos los registros como objetos.
- `getById($id)`: busca uno por ID; devuelve `null` si no existe.
- `actualizar($objeto)`: actualiza un registro.
- `eliminar($id)`: borra por ID.

Para crear registros se usan `setDirector($director)` y `setPelicula($pelicula)`. Las consultas preparadas enlazan los datos para las operaciones por ID.

### Panel y formularios

- `panel/index.php`: selecciona la vista con `?vista=directores` o `?vista=peliculas`, consulta el DAO y muestra el listado.
- `panel/director/formDirector.php` y `panel/pelicula/formPeliculas.php`: muestran formularios nuevos o cargan un registro cuando reciben `?id=...`.
- `crearDirector.php` y `crearPelicula.php`: reciben los datos `POST` y crean o actualizan según venga un ID.
- `eliminarDirector.php` y `eliminarPelicula.php`: reciben el ID y llaman al método `eliminar()`.

### Subida de carátulas

El formulario de películas usa `multipart/form-data`. `subirImagen()` en `panel/pelicula/crearPelicula.php` valida el archivo (JPG, PNG, WEBP o GIF, máximo 5 MB), crea un nombre aleatorio y lo guarda en `images/`. En la base de datos se guarda el nombre del archivo, no su contenido. Al editar, si no se selecciona otra imagen, se conserva la existente.

`css/panel.css` da estilo tanto al listado como a los formularios. Las carátulas se muestran desde `images/`.
