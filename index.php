<?php
require_once("clases/directorDao.php");

//crear un objeto dedirector

$directorDao = new DirectorDAO();

//funcion creada para que muestre la base de datos

$directores = $directorDao->getAll();


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
        <p><?= $d->getNombre() ?> - <?=  $d->getAnioNacimiento()?></p>
        <?php endforeach;?>
    
</body>
</html>