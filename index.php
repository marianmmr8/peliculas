<?php
require_once("clases/directorDao.php");

//crear un objeto dedirector

$directorDao = new DirectorDAO();

//funcion creada para que muestre la base de datos

$directores = $directorDao->getAll();
$miDirector = $directorDao->getById(10);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Directores</title>
</head>
<body>
    <?php  foreach($directores as $d):?>
        <h2><?= $d->getNombre() ?> - <?=  $d->getAnioNacimiento()?></h2>
        <p><?=  $d->getBiografia() ?></p>
        <?php endforeach;?>
    <h2>Mi director favorito es :</h2>
    <p><?=  $miDirector->getNombre() ?></p>
</body>
</html>