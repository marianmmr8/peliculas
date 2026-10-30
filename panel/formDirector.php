<?php
require_once __DIR__ . "/../clases/directorDao.php";
$directorDAO = new DirectorDao();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Director</title>
</head>
<body>
    <form action="crearDirector.php" method="POST">

<label for="nombre">Nombre</label>
<input type="text" name="nombre">

<label for="anio">Año de Nacimiento</label>
<input type="number" name ="anio">

<label for="biografia">Biografia</label>
<textarea name="biografia"></textarea>

<input type="submit" value="Enviar">

    </form>
</body>
</html>