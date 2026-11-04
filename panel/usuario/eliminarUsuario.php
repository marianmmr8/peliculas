<?php
require_once __DIR__ . "/../../clases/usuarioDAO.php";
$usuarioDAO = new UsuarioDao();

$id = $_GET["id"]?? null;

$usuarioDAO->eliminar($id);
header("Location: ../index.php?vista=usuarios");
exit;
?>