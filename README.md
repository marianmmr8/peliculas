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
- `panel/usuario/crearUsuario.php` y `panel/usuario/formUsuario.php`: crean o modifican usuarios y muestran un aviso si el nombre ya está en uso.
- `panel/director/formDirector.php` y `panel/pelicula/formPeliculas.php`: muestran formularios nuevos o cargan un registro cuando reciben `?id=...`.
- `crearDirector.php` y `crearPelicula.php`: reciben los datos `POST` y crean o actualizan según venga un ID.
- `eliminarDirector.php` y `eliminarPelicula.php`: reciben el ID y llaman al método `eliminar()`.

### Subida de carátulas

El formulario de películas usa `multipart/form-data`. `subirImagen()` en `panel/pelicula/crearPelicula.php` valida el archivo (JPG, PNG, WEBP o GIF, máximo 5 MB) y lo guarda en `images/` con un nombre formado por el título normalizado, el ID de la película y la extensión (por ejemplo, `amelie-12.webp`). `generarNombreImagen()` elimina acentos y caracteres especiales y sustituye los espacios por guiones. En la base de datos se guarda el nombre del archivo, no su contenido. Al editar, si no se selecciona otra imagen, se conserva la existente.

`css/panel.css` da estilo tanto al listado como a los formularios. Las carátulas se muestran desde `images/`.

## Documentación de funciones y métodos

Las clases PHP incluyen PHPDoc sobre cada método para explicar su propósito, los datos que recibe y lo que devuelve. Resumen:

### Modelos

- `peliculas::__construct()` inicializa todos los datos de una película. `getId()`, `getTitulo()`, `getDirector()`, `getAnio()`, `getGenero()`, `getImagen()` y `getVisto()` consultan cada propiedad. Los métodos `setId()`, `setTitulo()`, `setDirector()`, `setAnio()`, `setGenero()`, `setImagen()` y `setVisto()` actualizan la propiedad correspondiente.
- `Director::__construct()` inicializa los datos de un director. `getId()`, `getNombre()`, `getAnioNacimiento()` y `getBiografia()` consultan sus propiedades; `setId()`, `setNombre()`, `setAnionacimiento()` y `setBiografia()` las actualizan. `__toString()` genera una frase con el nombre y el año de nacimiento.

### Acceso a datos

- En `peliculasDAO`, `__construct()` abre la conexión a MySQL/MariaDB; `getAll()` recupera todas las películas; `getById()` busca una por ID; `setPelicula()` inserta una y devuelve el ID generado; `actualizar()` modifica una película existente; `eliminar()` borra una por ID.
- En `directorDao`, `__construct()` abre la conexión a la base de datos; `getAll()` recupera todos los directores; `getById()` busca uno por ID; `setDirector()` inserta un director; `actualizar()` modifica uno existente; `eliminar()` borra uno por ID.

### Funciones de carátulas

- `generarNombreImagen($titulo, $id, $extension)` convierte el título a texto ASCII, lo pasa a minúsculas, reemplaza los grupos de caracteres especiales por guiones y añade el ID y la extensión. Si el título queda vacío, usa `pelicula`.
- `subirImagen($archivo, $titulo, $id)` devuelve `null` si no se seleccionó archivo. En caso contrario, valida el error de subida, el límite de 5 MB, el tipo real de imagen y la carpeta de destino; después guarda el archivo con el nombre generado y lo devuelve. Si falla una validación o el guardado, lanza `RuntimeException`.

### Scripts del panel

Los siguientes archivos ejecutan su lógica directamente al abrirse o al recibir el formulario; no declaran funciones propias:

- `panel/index.php` selecciona la vista solicitada, obtiene las películas o los directores desde su DAO y genera la tabla correspondiente.
- `panel/pelicula/formPeliculas.php` y `panel/director/formDirector.php` muestran el formulario vacío o cargan los datos del registro indicado por `id`.
- `panel/pelicula/crearPelicula.php` crea o actualiza la película, gestiona la carátula y redirige al listado. Si al crear falla la subida, elimina el registro recién insertado para no dejar una película incompleta.
- `panel/director/crearDirector.php` crea o actualiza un director y redirige al listado.
- `panel/pelicula/eliminarPelicula.php` y `panel/director/eliminarDirector.php` leen el ID, eliminan el registro correspondiente y vuelven al listado.
