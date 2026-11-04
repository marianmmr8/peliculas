<?php
require_once __DIR__ . "/../../clases/usuarioDAO.php";
$usuarioDAO = new UsuarioDao();

$id = $_POST['id']  ?? "";
$nombre = $_POST["nombre"] ?? "";
$password = $_POST['password'] ?? '';

//si existe el id se puede modificar el director 
if($id){
$usuarioModificado = new usuario($nombre, $password, $id);
$usuarioDAO->actualizar($usuarioModificado);

}else{

$usuarioNuevo = new Usuario($nombre, $password);
$usuarioDAO->setUsuario($usuarioNuevo);
}


header("Location: ../index.php?vista=usuarios");
exit;
?>