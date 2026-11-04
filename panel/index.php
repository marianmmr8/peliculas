<?php
session_start();

require_once __DIR__ . "/../clases/usuarioDAO.php";
$usuarioDAO = new UsuarioDAO();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $nombre = $_POST["nombre"] ?? "";
  $passwordLogin = $_POST["password"] ?? "";
  $usuarioLogin = $usuarioDAO->existeUsuario($nombre, $passwordLogin);

  if ($usuarioLogin === null) {
    $_SESSION["mensaje"] = "Los datos no son correctos.";
    header("Location: login.php");
    exit();
  }

  $_SESSION["nombre"] = $usuarioLogin->getNombre();
}

if (empty($_SESSION["nombre"])) {
  header("Location: login.php");
  exit();
}



$vista =$_GET['vista'] ?? 'peliculas';

if($vista === 'peliculas'){
  require_once __DIR__ . "/../clases/peliculasDAO.php";
  $peliculasDAO = new peliculasDAO();
  $listaPeliculas =$peliculasDAO->getAll();
}
if($vista === 'directores'){
require_once __DIR__ . "/../clases/directorDao.php";
$directorDAO = new DirectorDao();
$listaDirectores = $directorDAO->getAll();
}
if($vista === 'usuarios'){
require_once __DIR__ . "/../clases/usuarioDAO.php";
$usuarioDAO = new UsuarioDao();
$listaUsuarios = $usuarioDAO->getAll();
}



?><!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de control</title>
    <h2>Hola <?=  $_SESSION['nombre'] ?> <span> <a href="cerrar.php">Cerrar Sesion</a></span></h2>
    <link rel="stylesheet" href="../css/panel.css">
</head>
<body>
  <main>
    <h1>Panel de control</h1>
    <nav>
      <ul>
      <li><a href="index.php?vista=directores">Directores</a></li>
      <li><a href="index.php?vista=peliculas">Peliculas</a></li>
      <li><a href="index.php?vista=usuarios">Usuarios</a></li>
      </ul>
    </nav>
    <?php  if ($vista  === "directores"):?>
    <a class="nuevo" href="director/formDirector.php">Nuevo director</a>

    <table >
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
            <td><a href="director/formDirector.php?id=<?=  $director->getId() ?>">Modificar</a></td>
            <td><a href="director/eliminarDirector.php?id=<?=  $director->getId() ?>">Eliminar</a></td>

        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <?php endif; ?>

    <?php  if ($vista  === "peliculas"):?>
      <h2>Mostrar la lista de peliculas</h2>
       <a class="nuevo" href="pelicula/formPeliculas.php">Nueva película</a>

    <table >
        <thead>
      <tr>
        <th>Titulo</th>
        <th>Director</th>
        <th>Año</th>
        <th>Género</th>
        <th>Imagen</th>
        <th>Vista</th>
        <th>Modificar</th>
        <th>Eliminar</th>
      </tr>
      </thead>
      <tbody>

    <?php foreach($listaPeliculas as $pelicula): ?>
    
      <tr>
            <td><?= $pelicula->getTitulo() ?></td>
            <td><?= $pelicula->getDirector() ?></td>
            <td><?= $pelicula->getAnio() ?></td>
            <td><?= $pelicula->getGenero() ?></td>
            <td>
              <?php if ($pelicula->getImagen() !== ''): ?>
                <img src="../images/<?= htmlspecialchars($pelicula->getImagen(), ENT_QUOTES, 'UTF-8') ?>" alt="Carátula de <?= htmlspecialchars($pelicula->getTitulo(), ENT_QUOTES, 'UTF-8') ?>" width="80">
              <?php else: ?>
                Sin imagen
              <?php endif; ?>
            </td>
            <td><?= $pelicula->getVisto() ? 'Vista' : "No" ?></td>

            <td><a href="pelicula/formPeliculas.php?id=<?=  $pelicula->getId() ?>">Modificar</a></td>
            <td><a href="pelicula/eliminarPelicula.php?id=<?=  $pelicula->getId() ?>">Eliminar</a></td>

        </tr>
        <?php endforeach; ?>

        </tbody>
    </table>
    <?php endif; ?>

    <?php if ($vista === "usuarios"): ?>
    <a class="nuevo" href="usuario/formUsuario.php">Nuevo Usuario</a>

    <table >
        <thead>
      <tr>
        <th>Nombre</th>
        <th>Password</th>
        <th>Modificar</th>
        <th>Eliminar</th>
      </tr>
      </thead>
      <tbody>

    <?php foreach($listaUsuarios as $usuario): ?>
        <tr>
            <td><?= $usuario->getNombre() ?></td>
            <td><?= $usuario->getPassword() ?></td>
            
            <td><a href="usuario/formUsuario.php?id=<?=  $usuario->getId() ?>">Modificar</a></td>
            <td><a href="usuario/eliminarUsuario.php?id=<?=  $usuario->getId() ?>">Eliminar</a></td>

        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <?php endif; ?>
  </main>
</body>
</html>