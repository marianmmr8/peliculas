<?php
session_start();
$mensaje = $_SESSION['mensaje'] ?? '';
unset($_SESSION['mensaje']);

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="../css/panel.css">
</head>
<body>
  

<form action="index.php" method="POST">
<h1>Iniciar sesión</h1>
<div class="content-form">
<label for="nombre">Nombre de Usuario</label>
<input type="text" id="nombre" name="nombre" placeholder="Nombre de usuario" required>
</div>
<div class="content-form">
<label for="password">Contraseña</label>
<input type="password" id="password" name="password" placeholder="Contraseña" required>
</div>
<div class="content-form">
<p><?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?></p>
<input type="submit" value="Iniciar sesión">
</div>
</form>
</body>
</html>