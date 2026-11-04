<?php
session_start();


require_once __DIR__ . "/../clases/usuarioDAO.php";


$usuarioDAO = new UsuarioDAO();
$usuario =$usuarioDAO->getById($_SESSION['is']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
</head>
<body>
    <h1><?=  $_SESSION['nombre'] ?></h1>
    <form action="usuario/crearUsuario.php" method="POST">
        <input type="text" name="id" value="<?=  $usuario ? $usuario->getId() : '' ?>" hidden >



<label for="nombre">Nombre</label>
<input type="text" name="nombre" value="<?=  $usuario ? $usuario->getNombre() : '' ?>">

<label for="password">Contraseña</label>
<input type="password" name ="password">
<label for="rol">Rol</label>
<input type="text" value="<?= $usuario->getRol() ?>"  disabled > 


<input type="submit" value="Enviar">

    </form>
</body>
</html>