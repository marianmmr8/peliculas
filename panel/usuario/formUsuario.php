<?php
session_start();

require_once __DIR__ . "/../../clases/usuarioDAO.php";
$usuarioDAO = new UsuarioDao();
$mensaje = $_SESSION["mensajeUsuario"] ?? "";
unset($_SESSION["mensajeUsuario"]);

//tenemos que comprobar si es para crear un nuevo director o modificar uno existente
$usuario = null;
if(isset($_GET["id"])){
$usuario =$usuarioDAO->getById($_GET["id"]);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuario</title>
    <link rel="stylesheet" href="../../css/panel.css">
</head>
<body>
    <form action="crearUsuario.php" method="POST">
        <input type="text" name="id" value="<?=  $usuario ? $usuario->getId() : '' ?>" hidden >

<p role="alert"><?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?></p>

<label for="nombre">Nombre</label>
<input type="text" name="nombre" value="<?=  $usuario ? $usuario->getNombre() : '' ?>">

<label for="password">Contraseña</label>
<input type="password" name ="password">

<input type="submit" value="Enviar">

    </form>
</body>
</html>