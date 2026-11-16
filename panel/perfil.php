<?php
session_start();


require_once __DIR__ . "/../clases/usuarioDAO.php";


$usuarioDAO = new UsuarioDAO();
$usuario = $usuarioDAO->getById($_SESSION['id']);
$mensaje = $_SESSION["mensajeUsuario"] ?? "";
unset($_SESSION["mensajeUsuario"]);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="../css/panel.css?v=3">
</head>
<body>
    <a class="panel-back-link" href="../index.php">Volver a la portada</a>
    <h1><?=  $_SESSION['nombre'] ?></h1>
    <form action="usuario/crearUsuario.php" method="POST">
        <input type="text" name="id" value="<?=  $usuario ? $usuario->getId() : '' ?>" hidden >
        <input type="hidden" name="desdePerfil" value="1">

<label for="nombre">Nombre</label>
<input type="text" name="nombre" value="<?=  $usuario ? $usuario->getNombre() : '' ?>">

<label for="password">Contraseña</label>
<input type="password" name ="password">
<p>Deja la contraseña vacía si no quieres cambiarla.</p>
<p role="alert"><?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?></p>
<label for="rol">Rol</label>
<input type="text" id="rol" value="<?= htmlspecialchars($usuario->getRol(), ENT_QUOTES, 'UTF-8') ?>" disabled>
<p>Solo un administrador puede cambiar tu rol desde la gestión de usuarios.</p>


<input type="submit" value="Enviar">

    </form>
</body>
</html>