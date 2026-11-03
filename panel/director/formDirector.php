<?php
require_once __DIR__ . "/../../clases/directorDao.php";
$directorDAO = new DirectorDao();
//tenemos que comprobar si es para crear un nuevo director o modificar uno existente
$director = null;
if(isset($_GET["id"])){
$director =$directorDAO->getById($_GET["id"]);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Director</title>
    <link rel="stylesheet" href="../../css/panel.css">
</head>
<body>
    <form action="crearDirector.php" method="POST">
        <input type="text" name="id" value="<?=  $director ? $director->getId() : '' ?>" hidden >

<label for="nombre">Nombre</label>
<input type="text" name="nombre" value="<?=  $director ? $director->getNombre() : '' ?>">

<label for="anio">Año de Nacimiento</label>
<input type="number" name ="anio" value="<?=  $director ? $director->getAnioNacimiento() : '' ?>">


<label for="biografia">Biografia</label>
<textarea name="biografia" value="<?=  $director ? $director->getBiografia() : '' ?>"></textarea>

<input type="submit" value="Enviar">

    </form>
</body>
</html>