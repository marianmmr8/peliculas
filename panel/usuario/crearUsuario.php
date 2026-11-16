<?php
session_start();

require_once __DIR__ . "/../../clases/usuarioDAO.php";
$usuarioDAO = new UsuarioDao();

$nombre = $_POST["nombre"] ?? "";
$password = $_POST["password"] ?? "";
$desdePerfil = ($_POST["desdePerfil"] ?? "") === "1";
$rol = $_POST["rol"] ?? "";

if ($desdePerfil) {
    $idUsuario = (int) ($_SESSION["id"] ?? 0);
    $usuarioActual = $idUsuario > 0 ? $usuarioDAO->getById($idUsuario) : null;
    if ($usuarioActual === null) {
        header("Location: ../login.php");
        exit;
    }

    $rol = $usuarioActual->getRol();
} else {
    $id = $_POST["id"] ?? "";
    $idUsuario = $id !== "" ? (int) $id : null;
}

$urlFormulario = "formUsuario.php" . ($idUsuario !== null ? "?id=" . $idUsuario : "");
if ($desdePerfil) {
    $urlFormulario = "../perfil.php";
}

if ($usuarioDAO->existeNombre($nombre, $idUsuario)) {
    $_SESSION["mensajeUsuario"] = "Usuario ocupado";
    header("Location: " . $urlFormulario);
    exit;
}

try {
    if ($idUsuario !== null) {
        $usuarioModificado = new Usuario($nombre, $password, $rol, $idUsuario);
        $usuarioDAO->actualizar($usuarioModificado);
    } else {
        $usuarioNuevo = new Usuario($nombre, $password, $rol);
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

if ($desdePerfil) {
    $_SESSION["nombre"] = $nombre;
    header("Location: ../perfil.php");
    exit;
}

header("Location: ../index.php?vista=usuarios");
exit;
?>