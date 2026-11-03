<?php
require_once __DIR__ . "/../../clases/peliculasDAO.php";
$peliculaDAO = new peliculasDAO();
//tenemos que comprobar si es para crear una nueva o modificar uno existente
$pelicula = null;
if(isset($_GET["id"])){
$pelicula =$peliculaDAO->getById($_GET["id"]);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelicula</title>
    <link rel="stylesheet" href="../../css/panel.css">
</head>
<body>
    <form action="crearPelicula.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="id" value="<?=  $pelicula ? $pelicula->getId() : '' ?>" hidden >

<label for="nombre">Titulo</label>
<input type="text" name="titulo" value="<?= $pelicula ? htmlspecialchars($pelicula->getTitulo(), ENT_QUOTES, 'UTF-8') : '' ?>">

<label for="director">Director</label>
<input type="text" name ="director" value="<?= $pelicula ? htmlspecialchars($pelicula->getDirector(), ENT_QUOTES, 'UTF-8') : '' ?>">

<label for="anio">Año</label>
<input type="number" name ="anio" value="<?= $pelicula ? $pelicula->getAnio() : '' ?>">

<label for="genero">Genero</label>
<input type="text" name ="genero" value="<?= $pelicula ? htmlspecialchars($pelicula->getGenero(), ENT_QUOTES, 'UTF-8') : '' ?>">

<label for="imagen">Imagen</label>
<input type="file" id="imagen" name="imagen" accept="image/jpeg, image/png, image/webp, image/gif">
<?php if ($pelicula && $pelicula->getImagen() !== ''): ?>
    <p>Imagen actual: <?= htmlspecialchars($pelicula->getImagen(), ENT_QUOTES, 'UTF-8') ?></p>
<?php endif; ?>

<label for="visto">Visto</label>
<input type="checkbox" id="visto" name="visto" value="1" <?= $pelicula && $pelicula->getVisto() ? 'checked' : '' ?>>

<input type="submit" value="Enviar">

    </form>
</body>
</html>