<?php
session_start();

require_once __DIR__ . "/../../clases/usuarioDAO.php";
$usuarioDAO = new UsuarioDao();

$id = $_POST["id"] ?? "";
$idUsuario = $id !== "" ? (int) $id : null;
$nombre = $_POST["nombre"] ?? "";
$password = $_POST["password"] ?? "";
$urlFormulario = "formUsuario.php" . ($idUsuario !== null ? "?id=" . $idUsuario : "");

if ($usuarioDAO->existeNombre($nombre, $idUsuario)) {
    $_SESSION["mensajeUsuario"] = "Usuario ocupado";
    header("Location: " . $urlFormulario);
    exit;
}

try {
    if ($idUsuario !== null) {
        $usuarioModificado = new Usuario($nombre, $password, $idUsuario);
        $usuarioDAO->actualizar($usuarioModificado);
    } else {
        $usuarioNuevo = new Usuario($nombre, $password);
        $usuarioDAO->setUsuario($usuarioNuevo);
    }
} catch (PDOException $error) {
    $esNombreDuplicado = $error->getCode() === "23000"
        && (int) ($error->errorInfo[1] ?? 0) === 1062;
    if (!$esNombreDuplicado) {
        throw $error;
    }

    $_SESSION["mensajeUsuario"] = "Usuario ocupado";
    header("Location: " . $urlFormulario);
    exit;
}

header("Location: ../index.php?vista=usuarios");
exit;
?>