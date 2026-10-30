<?php

require_once __DIR__ . "/../clases/directorDao.php";

$directorDAO = new DirectorDao();
$listaDirectores = $directorDAO->getAll();

// var_dump($listaDirectores);




?><!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de control</title>
    <link rel="stylesheet" href="../css/panel.css">
</head>
<body>
  <main>
    <h1>Panel de control</h1>
    <a class="nuevo" href="formDirector.php">Nuevo director</a>

    <table>
        <thead>
      <tr>
        <th>Nombre</th>
        <th>Nacimiento</th>
        <th>Biografia</th>
        <th>Modificar</th>
        <th>Eliminar</th>
      </tr>
      </thead>
      <tbody>
    <?php foreach($listaDirectores as $director): ?>
        <tr>
            <td><?= $director->getNombre() ?></td>
            <td><?= $director->getAnioNacimiento() ?></td>
            <td><?= $director->getBiografia() ?></td>
            <td><a href="formDirector.php?id=<?=  $director->getId() ?>">Modificar</a></td>
            <td><a href="eliminarDirector.php?id=<?=  $director->getId() ?>">Eliminar</a></td>

        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
  </main>
</body>
</html>