<?php
require_once __DIR__ . "/../../clases/peliculasDao.php";
$directorDAO = new peliculasDao();
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
    <form action="crearPelicula.php" method="POST">
        <input type="text" name="id" value="<?=  $pelicula ? $pelicula->getId() : '' ?>" hidden >

<label for="nombre">Titulo</label>
<input type="text" name="titulo" value="<?=  $pelicula ? $pelicula->getTitulo() : '' ?>">

<label for="director">Director</label>
<input type="text" name ="director" value="<?=  $pelicula ? $pelicula->getDirector() : '' ?>">

<label for="anio">Año</label>
<input type="number" name ="anio" value="<?=  $pelicula ? $pelicula->getAnio() : '' ?>">

<label for="genero">Genero</label>
<input type="text" name ="genero" value="<?=  $pelicula ? $pelicula->getGenero() : '' ?>">

<label for="imagen">Imagen</label>
<input type="text" name ="imagen" value="<?=  $pelicula ? $pelicula->getImagen() : '' ?>">

<label for="visto">Visto</label>
<input type="text" name ="visto" value="<?=  $pelicula ? $pelicula->getVisto() : '' ?>">

<input type="submit" value="Enviar">

    </form>
</body>
</html>